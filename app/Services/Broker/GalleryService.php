<?php

namespace App\Services\Broker;

use App\Interfaces\Broker\GalleryRepositoryInterface;
use App\Interfaces\Broker\UnitRepositoryInterface;
use App\Models\Broker;
use App\Models\City;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\Unit;
use App\Models\UnitImage;
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
        ], [
            'gallery_name.required' => __('The gallery name field is required.'),
            'gallery_name.unique' => __('The gallery name has already been taken.'),
        ]);

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
        $data = $request->validate([
            'gallery_id' => 'required',
            'gallery_cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'gallery_id.required' => 'Please select a gallery.',
            'gallery_cover.required' => 'Please upload a gallery cover image.',
            'gallery_cover.image' => 'The gallery cover must be an image.',
            'gallery_cover.mimes' => 'The gallery cover must be a valid image file (JPEG, PNG, JPG).',
            'gallery_cover.max' => 'The gallery cover must not exceed 2048 kilobytes in size.',
        ]);


        return $this->galleryRepository->updateCover($data);
    }


    public function showUnitPublic($galleryName, $id)
    {
        $gallery = $this->galleryRepository->findByGalleryName($galleryName);
        if ($gallery->gallery_status == 0) {
            $brokerId = $gallery->broker_id;
            $broker = Broker::findOrFail($brokerId);
            $gallery = $this->galleryRepository->findByGalleryName($galleryName);
            return get_defined_vars();
        }else{

        $units = $this->UnitRepository->getAll($gallery['broker_id'])->where('show_gallery', 1);
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
    }

    public function showByName($name, $cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter,$typeUseFilter,$adTypeFilter,$priceFrom , $priceTo ,$hasImageFilter , $hasPriceFilter,$daily_rent)

    {
        $usages =  $this->propertyUsageService->getAll();
        $gallery = $this->galleryRepository->findByGalleryName($name);
        if ($gallery->gallery_status == 0) {
            $brokerId = $gallery->broker_id;
            $broker = Broker::findOrFail($brokerId);
            $gallery = $this->galleryRepository->findByGalleryName($name);
            return get_defined_vars(); // Return data to be passed to the view
        }else{

        $units = $this->UnitRepository->getAll($gallery['broker_id'])->where('show_gallery', 1);
        $uniqueIds = $units->pluck('CityData.id')->unique();
        $uniqueNames = $units->pluck('CityData.name')->unique();
        $units = $this->filterUnitsPublic($units, $cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter , $hasPriceFilter,$daily_rent );
        $unit = $units->first();
        if ($unit) {
            $id = $unit->id;
            $unit_id = $unit->id;
            $broker = Broker::findOrFail($unit->broker_id);
            $user_id = $broker->user_id;
        } else {
            $unit_id = null;
            $unitDetails = null;
            $user_id = null;
        }
        $districts = Gallery::where('id', $gallery->id)->first()->BrokerData->BrokerHasUnits;
        $districtsIds = $districts->pluck('district_id')->toArray();
        $projectuniqueIds = $units->pluck('PropertyData.ProjectData.id')->filter()->unique();
        $projectUniqueNames = $units->pluck('PropertyData.ProjectData.name')->unique();
        $propertyuniqueIds = $units->pluck('PropertyTypeData.id')->filter()->unique();
        $propertyUniqueNames = $units->pluck('PropertyTypeData.name')->unique();
        return get_defined_vars();
    }

    }


    public function showAllGalleries($cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter,$typeUseFilter,$adTypeFilter,$priceFrom , $priceTo ,$hasImageFilter , $hasPriceFilter,$daily_rent)

    {
        $usages =  $this->propertyUsageService->getAll();
        $galleries = $this->galleryRepository->allPublic();
        $units = collect();

        foreach ($galleries as $gallery) {
            $galleryUnits = $this->UnitRepository->getAll($gallery['broker_id'])->where('show_gallery', 1);

            $units = $units->merge($galleryUnits);
        }
        $unit_id = null;
        $unitDetails = null;
        $user_id = null;

        if ($units) {
        foreach($units as $unit){
            $broker = Broker::findOrFail($unit->broker_id);
            $unit_id = $unit->id;
            $user_id = $broker->user_id;
        }
    }

        $uniqueIds = $units->pluck('CityData.id')->unique();
        $uniqueNames = $units->pluck('CityData.name')->unique();
        $units = $this->filterUnitsPublic($units, $cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter , $hasPriceFilter,$daily_rent );
        $districts = Gallery::where('id', $gallery->id)->first()->BrokerData->BrokerHasUnits;
        $districtsIds = $districts->pluck('district_id')->toArray();
        $projectuniqueIds = $units->pluck('PropertyData.ProjectData.id')->filter()->unique();
        $projectUniqueNames = $units->pluck('PropertyData.ProjectData.name')->unique();
        $propertyuniqueIds = $units->pluck('PropertyTypeData.id')->filter()->unique();
        $propertyUniqueNames = $units->pluck('PropertyTypeData.name')->unique();
        $districtsuniqueIds = $units->pluck('DistrictData.id')->filter()->unique();
        $districtsUniqueNames = $units->pluck('DistrictData.name')->unique();

        return get_defined_vars();

    }
    public function filterUnitsPublic($units, $cityFilter,$propertyTypeFilter,$districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter , $hasPriceFilter,$daily_rent)
    {
        // Filter by city if not 'all'
        if ($cityFilter !== 'all' ) {
            $units = $units->where('city_id', $cityFilter);
        }

        if ($propertyTypeFilter !== 'all') {
            $units = $units->where('PropertyTypeData.id', $propertyTypeFilter);
        }

        // Filter by project if not 'all'
        if ($projectFilter !== 'all') {
            $units = $units->where('PropertyData.ProjectData.id', $projectFilter);

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


            if ($hasImageFilter) {
                $unitIdsWithImages = UnitImage::pluck('unit_id')->toArray();
                $units = $units->filter(function ($unit) use ($unitIdsWithImages) {
                    return in_array($unit->id, $unitIdsWithImages);
                });
            }


            // Filter by units with price
            if ($hasPriceFilter) {
                $units = $units->whereNotNull('price');
            }

            if ($daily_rent) {
                $units = $units->where('daily_rent' , 1);
            }

            if ($districtFilter !== 'all') {
                $units = $units->where('district_id', $districtFilter);
            }

            return $units;
    }

    public function filterUnits($units, $adTypeFilter,$propertyTypeFilter, $typeUseFilter, $cityFilter, $districtFilter,$projectFilter,$dailyFilter)
    {
        // Filter by advertisement type if not 'all'
        if ($adTypeFilter !== 'all') {
            $units = $units->where('type', $adTypeFilter);
        }
        if ($propertyTypeFilter !== 'all') {
            $units = $units->where('PropertyTypeData.id', $propertyTypeFilter);
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
        if ($projectFilter !== 'all') {
            $units = $units->where('PropertyData.ProjectData.id', $projectFilter);
        }

        if ($dailyFilter !== 'all') {
            $dailyRentValue = ($dailyFilter === 'Available') ? 1 : 0;
            $units = $units->where('daily_rent', $dailyRentValue);
        }

        return $units;
    }






}
