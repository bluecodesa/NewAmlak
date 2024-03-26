<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Broker;
use App\Models\City;
use App\Models\Project;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Validation\Rule;

class GalleryService
{
    protected $galleryRepository;
    protected $UnitRepository;


    public function __construct(UnitRepositoryInterface $UnitRepository,GalleryRepositoryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
        $this->UnitRepository = $UnitRepository;

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

    public function showByName($name, $city_filter, $prj_filter, $type_filter, $price_from, $price_to, $rent_status, $without_images, $with_images, $with_price, $without_price, $reserved_units)
    {
        $gallery = $this->galleryRepository->findByGalleryName($name);
        if ($gallery->gallery_status == 0) {
            return [];
        }else{

        $units = $this->UnitRepository->getAll($gallery['broker_id']);
        $cities = City::all();
        $projects =Project::all();
        $filteredUnits = $this->filterUnitsPublic($units, $city_filter, $prj_filter, $type_filter, $price_from, $price_to, $rent_status, $without_images, $with_images, $with_price, $without_price, $reserved_units);


        $unit = $units->first();
        $id = $unit ? $unit->id : null;

        $unitDetails = $id ? $this->galleryRepository->findById($id) : null;

        $unit_id=$unit->id;

        $broker=Broker::findOrFail($unit->broker_id);
        $user_id=$broker->user_id;
        return get_defined_vars();
        }
    }

    public function filterUnits($units, $adTypeFilter, $typeUseFilter, $cityFilter, $districtFilter)
{
    if ($adTypeFilter !== 'all') {
        $units = $units->where('type', $adTypeFilter);
    }


    if ($typeUseFilter !== 'all') {
        $units = $units->where('property_usage_id', $typeUseFilter);
    }


    if (!is_null($cityFilter)) {
        $units = $units->where('city_id', $cityFilter);
    }


    if (!is_null($districtFilter)) {
        $units = $units->where('district_id', $districtFilter);
    }

    // dd($units);



    // if (!is_null($projectFilter)) {
    //     $units = $units->where('project_id', $projectFilter);
    // }

    return $units;
}

private function filterUnitsPublic($units, $city_filter, $prj_filter, $type_filter, $price_from, $price_to, $rent_status, $without_images, $with_images, $with_price, $without_price, $reserved_units)
{
    // Apply filters on units based on parameters
    $filteredUnits = $units;

    // Implement filtering logic here based on the parameters

    // Filter by city
    if ($city_filter != 'all') {
        $filteredUnits = $filteredUnits->where('city', $city_filter);
    }

    // Filter by project
    if ($prj_filter != 'all') {
        $filteredUnits = $filteredUnits->where('project_id', $prj_filter);
    }

    // Filter by type
    if ($type_filter != 'all') {
        $filteredUnits = $filteredUnits->where('type', $type_filter);
    }

    // Filter by price range
    if ($price_from && $price_to) {
        $filteredUnits = $filteredUnits->whereBetween('price', [$price_from, $price_to]);
    } elseif ($price_from) {
        $filteredUnits = $filteredUnits->where('price', '>=', $price_from);
    } elseif ($price_to) {
        $filteredUnits = $filteredUnits->where('price', '<=', $price_to);
    }

    // Filter by rent status
    if ($rent_status) {
        $filteredUnits = $filteredUnits->where('rent_status', $rent_status);
    }

    // Filter by image presence
    if ($without_images) {
        $filteredUnits = $filteredUnits->where('image', null);
    } elseif ($with_images) {
        $filteredUnits = $filteredUnits->whereNotNull('image');
    }

    // Filter by price presence
    if ($with_price) {
        $filteredUnits = $filteredUnits->whereNotNull('price');
    } elseif ($without_price) {
        $filteredUnits = $filteredUnits->whereNull('price');
    }

    // Filter by reserved units
    if ($reserved_units) {
        $filteredUnits = $filteredUnits->where('reserved', true);
    }

    return $filteredUnits;
}



}
