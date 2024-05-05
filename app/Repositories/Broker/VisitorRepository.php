<?php

namespace App\Repositories\Broker;

use App\Interfaces\Broker\VisitorRepositoryInterface;
use App\Models\Visitor;

class VisitorRepository implements VisitorRepositoryInterface
{


    public function all()
    {
        return Visitor::all();
    }

    public function find($id)
    {
        return Visitor::findOrFail($id);
    }

    public function create(array $data)
    {
        return Visitor::create($data);
    }

    public function update($id, array $data)
    {
        $visitor = $this->find($id);
        $visitor->update($data);
        return $visitor;
    }

    public function delete($galleryId)
    {
        $gallery = Visitor::find($galleryId);
        $gallery->delete();
    }

}
