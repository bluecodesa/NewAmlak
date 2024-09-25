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
use App\Models\Visitor;
use App\Repositories\Broker\UnitRepository;
use App\Repositories\Broker\ProjectRepository;
use App\Repositories\Broker\PropertyRepository;
use App\Services\Admin\PropertyUsageService;
use Illuminate\Validation\Rule;
use App\Interfaces\Admin\TicketTypeRepositoryInterface;
use App\Models\Advertising;
use App\Models\Property;

class GalleryService
{
    protected $galleryRepository;
    protected $UnitRepository;
    protected $ProjectRepository;

    protected $PropertyRepository;

    protected $unitRepository;

    protected $propertyUsageService;

    protected $ticketTypeRepository;


    public function __construct(
        UnitRepositoryInterface $UnitRepository,
        UnitRepository $unitRepository,
        PropertyRepository $PropertyRepository,
        ProjectRepository $ProjectRepository,
        GalleryRepositoryInterface $galleryRepository,
        PropertyUsageService  $propertyUsageService,
        TicketTypeRepositoryInterface $ticketTypeRepository

    ) {
        $this->galleryRepository = $galleryRepository;
        $this->UnitRepository = $UnitRepository;
        $this->unitRepository = $unitRepository;
        $this->ProjectRepository = $ProjectRepository;
        $this->PropertyRepository = $PropertyRepository;
        $this->propertyUsageService = $propertyUsageService;
        $this->ticketTypeRepository = $ticketTypeRepository;

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
        $request = request();
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
        $request = request();
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
        } else {

            $units = $this->UnitRepository->getAll($gallery['broker_id'])->where('show_gallery', 1);
            $Unit = $this->UnitRepository->findById($id);

            if (!$Unit) {
                abort(404);
            }

            $gallery = $this->galleryRepository->findByBrokerId($gallery->broker_id);

            $broker = Broker::findOrFail($Unit->broker_id);
            $brokers = User::findOrFail($broker->user_id);
            $unit_id = $Unit->id;
            $user_id = $broker->user_id;



            $visitor = Visitor::where('unit_id', $id)
                ->where('ip_address', request()->ip())
                ->where('visited_at', '>=', now()->subHour())
                ->first();

            if (!$visitor) {

                $newVisitor = new Visitor();
                $newVisitor->unit_id = $id;
                $newVisitor->gallery_id = $gallery->id;
                $newVisitor->ip_address = request()->ip();
                $newVisitor->visited_at = now();
                $newVisitor->save();
            }
            $unitVisitorsCount = Visitor::where('unit_id', $Unit->id)->distinct('ip_address')->count('ip_address');
            $ticketTypes = $this->ticketTypeRepository->all();

            return get_defined_vars();
        }
    }

    public function showByName($name, $cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent)

    {

        $usages =  $this->propertyUsageService->getAll();
        $gallery = $this->galleryRepository->findByGalleryName($name);
        $brokerId = $gallery->broker_id;
        if ($gallery->gallery_status == 0) {
            $brokerId = $gallery->broker_id;
            $broker = Broker::findOrFail($brokerId);
            $gallery = $this->galleryRepository->findByGalleryName($name);
            return get_defined_vars(); // Return data to be passed to the view
        } else {

            $units = $this->UnitRepository->getAll($gallery['broker_id'])->where('show_gallery', 1);
            $projects = $this->ProjectRepository->getAllByBrokerId($gallery['broker_id'])->where('show_in_gallery', 1);
            $properties = $this->PropertyRepository->getAll($gallery['broker_id'])->where('show_in_gallery', 1);

            $units->each(function ($unit) {
                $unit->isGalleryUnit = true;
            });
            $projects->each(function ($project) {
                $project->isGalleryProject = true;
            });
            $properties->each(function ($propertie) {
                $propertie->isGalleryProperty = true;
            });
            $allItems = $projects->merge($properties)->merge($units);

            $uniqueIds = $units->pluck('CityData.id')->unique();
            $uniqueNames = $units->pluck('CityData.name')->unique();
            $districts = Gallery::where('id', $gallery->id)->first()->BrokerData->BrokerHasUnits;
            $districtsIds = $districts->pluck('district_id')->toArray();
            $projectuniqueIds = $units->pluck('PropertyData.ProjectData.id')->filter()->unique();
            $projectUniqueNames = $units->pluck('PropertyData.ProjectData.name')->unique();
            $propertyuniqueIds = $units->pluck('PropertyTypeData.id')->filter()->unique();
            $propertyUniqueNames = $units->pluck('PropertyTypeData.name')->unique();
            $allItems = $this->filterUnitsPublic($allItems, $cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent);
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
                $broker = Broker::findOrFail($brokerId);
            }
            $ticketTypes = $this->ticketTypeRepository->all();

            return get_defined_vars();
        }
    }

    public function showAllGalleries($cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent)

    {
        $usages =  $this->propertyUsageService->getAll();
        $galleries = $this->galleryRepository->allPublic();
        $units = collect();
        $districts = collect();
        $allItems = collect();
        $galleries = Gallery::whereNotNull('broker_id')->where('gallery_status', 1)->get();
        foreach ($galleries as $gallery) {
            $projects = $this->ProjectRepository->getAllByBrokerId($gallery['broker_id'])->where('show_in_gallery', 1);
            $properties = $this->PropertyRepository->getAll($gallery['broker_id'])->where('show_in_gallery', 1);
            $galleryUnits = Unit::where('broker_id', $gallery->broker_id)
                ->where('show_gallery', 1)
                ->get();
            // $units = $units->merge($galleryUnits);
            $galleryUnits->each(function ($unit) {
                $unit->isGalleryUnit = true;
            });
            $projects->each(function ($project) {
                $project->isGalleryProject = true;
            });
            $properties->each(function ($propertie) {
                $propertie->isGalleryProperty = true;
            });
            $galleryItems = $projects->merge($properties)->merge($galleryUnits);
            $allItems = $allItems->merge($galleryItems);

            $this->updateAdLicenseStatus(Project::all());
            $this->updateAdLicenseStatus(Property::all());
            $this->updateAdLicenseStatus(Unit::all());

        }

        $uniqueIds = $allItems->pluck('CityData.id')->unique();
        $uniqueNames = $allItems->pluck('CityData.name')->unique();
        $allItems = $this->filterUnitsPublic($allItems, $cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent);
        $projectuniqueIds = $units->pluck('PropertyData.ProjectData.id')->filter()->unique();
        $projectUniqueNames = $units->pluck('PropertyData.ProjectData.name')->unique();
        $propertyuniqueIds = $units->pluck('PropertyTypeData.id')->filter()->unique();
        $propertyUniqueNames = $units->pluck('PropertyTypeData.name')->unique();
        $districtsuniqueIds = $allItems->pluck('DistrictData.id')->filter()->unique();
        $districtsUniqueNames = $allItems->pluck('DistrictData.name')->unique();
        $ticketTypes = $this->ticketTypeRepository->all();

        return get_defined_vars();
    }

    protected function updateAdLicenseStatus($items)
{
    foreach ($items as $item) {
        if (isset($item->ad_license_expiry) && $item->ad_license_expiry < now()->format('Y-m-d')) {
            $item->update(['ad_license_status' => 'InValid']);
        }
    }
}

    public function filterUnitsPublic($allItems, $cityFilter, $propertyTypeFilter, $districtFilter, $projectFilter, $typeUseFilter, $adTypeFilter, $priceFrom, $priceTo, $hasImageFilter, $hasPriceFilter, $daily_rent)
    {
        // Filter by city if not 'all'
        if ($cityFilter !== 'all') {
            $allItems = $allItems->where('city_id', $cityFilter);
        }

        if ($propertyTypeFilter !== 'all') {
            $allItems = $allItems->where('PropertyTypeData.id', $propertyTypeFilter);
        }

        // Filter by project if not 'all'
        if ($projectFilter !== 'all') {
            $units = $allItems->where('PropertyData.ProjectData.id', $projectFilter);
        }

        // Filter by property usage if not 'all'
        if ($typeUseFilter !== 'all') {
            $allItems = $allItems->where('property_usage_id', $typeUseFilter);
        }

        if ($adTypeFilter !== 'all') {
            $allItems = $allItems->where('type', $adTypeFilter);
        }

        // Filter by price range (from and to)
        if ($priceFrom !== null && $priceFrom !== '') {
            $allItems = $allItems->where('price', '>=', $priceFrom);
        }

        if ($priceTo !== null && $priceTo !== '') {
            $allItems = $allItems->where('price', '<=', $priceTo);
        }


        if ($hasImageFilter) {
            $unitIdsWithImages = UnitImage::pluck('unit_id')->toArray();
            $allItems = $allItems->filter(function ($unit) use ($unitIdsWithImages) {
                return in_array($unit->id, $unitIdsWithImages);
            });
        }


        // Filter by units with price
        if ($hasPriceFilter) {
            $allItems = $allItems->whereNotNull('price');
        }

        if ($daily_rent) {
            $allItems = $allItems->where('daily_rent', 1);
        }

        if ($districtFilter !== 'all') {
            $allItems = $allItems->where('district_id', $districtFilter);
        }

        return $allItems;
    }

    public function filterUnits($allItems, $adTypeFilter, $propertyTypeFilter, $typeUseFilter, $cityFilter, $districtFilter, $projectFilter, $dailyFilter)
    {
        // Filter by advertisement type if not 'all'
        if ($adTypeFilter !== 'all') {
            $allItems = $allItems->where('type', $adTypeFilter);
        }
        if ($propertyTypeFilter !== 'all') {
            $allItems = $allItems->where('PropertyTypeData.id', $propertyTypeFilter);
        }


        // Filter by property usage if not 'all'
        if ($typeUseFilter !== 'all') {
            $allItems = $allItems->where('property_usage_id', $typeUseFilter);
        }

        // Filter by city if not 'all'
        if ($cityFilter !== 'all') {
            $allItems = $allItems->where('city_id', $cityFilter);
        }

        // Filter by district if not 'all'
        if ($districtFilter !== 'all') {
            $allItems = $allItems->where('district_id', $districtFilter);
        }
        if ($projectFilter !== 'all') {
            $allItems = $allItems->where('PropertyData.ProjectData.id', $projectFilter);
        }

        if ($dailyFilter !== 'all') {
            $dailyRentValue = ($dailyFilter === 'Available') ? 1 : 0;
            $allItems = $allItems->where('daily_rent', $dailyRentValue);
        }

        return $allItems;
    }
}
