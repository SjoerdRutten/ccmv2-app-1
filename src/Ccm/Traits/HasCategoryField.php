<?php

namespace Sellvation\CCMV2\Ccm\Traits;

use Sellvation\CCMV2\Ccm\Models\Category;

trait HasCategoryField
{
    public string $add_category_name = '';

    public function saveAddCategory()
    {
        $this->validate([
            'add_category_name' => 'required|string',
        ]);

        $category = Category::create([
            'name' => $this->add_category_name,
        ]);

        if (property_exists($this, 'form')) {
            $this->form->category_id = $category->id;
        } elseif (property_exists($this, 'category_id')) {
            $this->category_id = $category->id;
        }
    }
}
