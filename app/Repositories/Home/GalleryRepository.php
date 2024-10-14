<?php

namespace App\Repositories\Home;

use App\Interfaces\Home\GalleryRepositoryInterface;
use App\Models\Broker;
use App\Models\Gallery;
use App\Models\Office;
use App\Models\Project;
use App\Models\Property;
use App\Models\Visitor;

class GalleryRepository implements GalleryRepositoryInterface
{


    public function all()
    {
        return Gallery::all();
    }
    public function allPublic()
    {
        return Gallery::where('gallery_status',1)->get();
    }


    public function findById($galleryId)
    {
        return Gallery::findOrFail($galleryId);
    }


    public function findByBrokerId($brokerId)
    {
        return Gallery::where('broker_id', $brokerId)->first();
    }

    public function findByOfficeId($officeId)
    {
        return Gallery::where('office_id', $officeId)->first();
    }


    public function findByGalleryName($galleryName)
    {
        return Gallery::where('gallery_name', $galleryName)->firstOrFail();
    }

    function ShowPublicProperty($id)
    {
        $property = Property::where('show_in_gallery', 1)->find($id);

        if($property){
            if($property->broker_id){
                $broker = Broker::findOrFail($property->broker_id);
                $gallery =Gallery::where('broker_id', $broker->id)->first();
            }elseif($property->office_id){
                $office = Office::findOrFail($property->office_id);
                $gallery =Gallery::where('office_id', $office->id)->first();
            }


            $visitor = Visitor::where('property_id', $id)
            ->where('ip_address', request()->ip())
            ->where('visited_at', '>=', now()->subHour())
            ->first();


        if (!$visitor) {

            $newVisitor = new Visitor();
            $newVisitor->property_id = $id;
            $newVisitor->gallery_id = $gallery->id;
            $newVisitor->ip_address = request()->ip();
            $newVisitor->visited_at = now();
            $newVisitor->save();
        }
        $unitVisitorsCount = Visitor::where('property_id', $property->id)->distinct('ip_address')->count('ip_address');

            return $property;
        }


    }

    function ShowPublicProject($id)
    {
        $project = Project::where('show_in_gallery', 1)->find($id);
        return $project;

    }
}
