<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Broker;
use App\Models\City;
use App\Models\Project;
use App\Models\Unit;
use App\Models\User;
use App\Services\Admin\PropertyUsageService;
use Illuminate\Validation\Rule;

class GalleryService
{
    protected $galleryRepository;
    protected $UnitRepository;
    protected $propertyUsageService;



    public function __construct(UnitRepositoryInterface $UnitRepository,
    GalleryRepositoryInterface $galleryRepository,
    PropertyUsageService  $propertyUsageService

    )
    {
        $this->galleryRepository = $galleryRepository;
        $this->UnitRepository = $UnitRepository;
        $this->propertyUsageService =$propertyUsageService;

    }


    public function all()
    {
        return $this->galleryRepository->all();
    }

    public function findById($galleryId)
    {
        return $this->galleryRepository->findById($galleryId);
    }

    public function create(array $data)
    {

        return $this->galleryRepository->create($data);
    }

    public function update(array $data, $galleryId)
    {
        $request=request();
        $data = $request->validate([
            'gallery_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('galleries')->ignore($galleryId),
            ],
            'gallery_status' => 'nullable|in:0,1',
        ]);
        $messages = [
            'gallery_name.required' => __('The gallery_name field is required.'),
            'gallery_name.unique' => __('The gallery_name has already been taken.'),
        ];
        validator($data, $messages)->validate();

        $gallery = $this->galleryRepository->findById($galleryId);

        $gallery->update([
            'gallery_name' => $data['gallery_name'],
            'gallery_status' => $request->has('gallery_status') ? '1' : '0',
        ]);

        return $this->galleryRepository->update($data, $galleryId);

    }

    public function delete($galleryId)
    {
        return $this->galleryRepository->delete($galleryId);
    }

    public function findByBrokerId($brokerId)
    {
        return $this->galleryRepository->findByBrokerId($brokerId);
    }



    public function updateCover(array $data)
    {
        $request=request();
        $data=$request->validate([
            'gallery_id' => 'required',
            'gallery_cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return $this->galleryRepository->updateCover($data);
    }


    public function showUnitPublic($galleryName, $id)
    {
        $gallery = $this->galleryRepository->findByGalleryName($galleryName);

        if ($gallery->gallery_status == 0) {
            return [];
        }

        $units = $this->UnitRepository->getAll($gallery['broker_id']);
        $Unit = $this->UnitRepository->findById($id);
        if (!$Unit) {
            abort(404);
        }

        $gallery = $this->galleryRepository->findByBrokerId($gallery->broker_id);

        $broker=Broker::findOrFail($Unit->broker_id);
        $brokers=User::findOrFail($broker->user_id);
        $unit_id=$Unit->id;
        $user_id=$broker->user_id;

        return get_defined_vars();
    }

    public function showByName($name, $cityFilter, $projectFilter,$typeUseFilter,$adTypeFilter,$priceFrom , $priceTo )

    {
        $usages =  $this->propertyUsageService->getAll();

        $gallery = $this->galleryRepository->findByGalleryName($name);
        if ($gallery->gallery_status == 0) {
            return [];
        }else{

        $units = $this->UnitRepository->getAll($gallery['broker_id']);
        $uniqueIds = $units->pluck('CityData.id')->unique();
        $uniqueNames = $units->pluck('CityData.name')->unique();
        $units = $this->filterUnitsPublic($units, $cityFilter,$projectFilter, $typeUseFilter,$adTypeFilter,$priceFrom, $priceTo);
        $unit = $units->first();

        if ($unit) {
            $id = $unit->id;
            // $unitDetails = $this->galleryRepository->findById($id);
            $unit_id = $unit->id;
            $broker = Broker::findOrFail($unit->broker_id);
            $user_id = $broker->user_id;
        } else {
            $unit_id = null;
            $unitDetails = null;
            $user_id = null;
        }

        return get_defined_vars();
    }

}

public function filterUnitsPublic($units, $cityFilter, $projectFilter, $typeUseFilter,$adTypeFilter, $priceFrom, $priceTo)
{
    // Filter by city if not 'all'
    if ($cityFilter !== 'all' ) {
        $units = $units->where('city_id', $cityFilter);
    }

    // Filter by project if not 'all'
    if ($projectFilter !== 'all') {
        $units = $units->where('project_id', $projectFilter);
    }

    // Filter by property usage if not 'all'
    if ($typeUseFilter !== 'all') {
        $units = $units->where('property_usage_id', $typeUseFilter);
    }

    if ($adTypeFilter !== 'all') {
        $units = $units->where('type', $adTypeFilter);
    }

    // Filter by price range (from and to)
        if ($priceFrom !== null && $priceFrom !== '') {
            $units = $units->where('price', '>=', $priceFrom);
        }

        if ($priceTo !== null && $priceTo !== '') {
            $units = $units->where('price', '<=', $priceTo);
        }

        return $units;
    }

    public function filterUnits($units, $adTypeFilter, $typeUseFilter, $cityFilter, $districtFilter)
    {
        // Filter by advertisement type if not 'all'
        if ($adTypeFilter !== 'all') {
            $units = $units->where('type', $adTypeFilter);
        }

        // Filter by property usage if not 'all'
        if ($typeUseFilter !== 'all') {
            $units = $units->where('property_usage_id', $typeUseFilter);
        }

        // Filter by city if not 'all'
        if ($cityFilter !== 'all') {
            $units = $units->where('city_id', $cityFilter);
        }

        // Filter by district if not 'all'
        if ($districtFilter !== 'all') {
            $units = $units->where('district_id', $districtFilter);
        }

        return $units;
    }






}
