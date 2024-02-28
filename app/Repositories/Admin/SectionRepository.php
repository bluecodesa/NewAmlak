<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\SectionRepositoryInterface;
use App\Models\Section;

class SectionRepository implements SectionRepositoryInterface
{
    public function getAll()
    {
        return Section::get();
    }

    public function create($data)
    {
        return Section::create($data);
    }

    function getById($id)
    {
        return Section::find($id);
    }

    public function update($id, $data)
    {
        $Section = Section::findOrFail($id);
        $Section->update($data);
        return $Section;
    }

    public function delete($id)
    {
        return Section::findOrFail($id)->delete();
    }
}
