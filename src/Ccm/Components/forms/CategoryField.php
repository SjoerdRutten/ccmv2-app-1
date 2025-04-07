<?php

namespace Sellvation\CCMV2\Ccm\Components\forms;

use Illuminate\View\Component;
use Sellvation\CCMV2\Ccm\Models\Category;

class CategoryField extends Component
{
    public function render()
    {
        $categories = Category::orderBy('name')->get();

        return view('ccm::components.forms.categories')
            ->with([
                'categories' => $categories,
            ]);
    }
}
