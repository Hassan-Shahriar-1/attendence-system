<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class StudentBuilder extends Builder
{
    public function searchByName()
    {
        $search = request('search');
        if (!empty($search)) {
            return $this->where(function ($query) use ($search) {
                $query->where('name', 'ilike', '%' . $search . '%')
                    ->orWhereHas('grade', function ($q) use ($search) {
                        $q->where('name', 'ilike', '%' . $search . '%');
                    });
            });
        }
        return $this;
    }
}
