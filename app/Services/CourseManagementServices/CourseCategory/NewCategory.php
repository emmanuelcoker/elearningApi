<?php

namespace App\Services\CourseManagementServices\CourseCategory;

abstract class NewCategory
{
    abstract public function createCategory();
    abstract public function allCategories();
    abstract public function updateCategory($categoryId, $data);
    abstract public function deleteCategory($categoryId);

}