<?php

class CategoryController
{
    public function allCategoriesSelect()
    {
        $categories = CategoryModel::getAllCategories();

        foreach ($categories as $category) {
            echo '<option value="' . htmlspecialchars($category['id_category']) . '">' . htmlspecialchars($category['description']) . '</option>';
        }
    }

    public function categoriesSelect($selectedCategory)
    {
        $categories = CategoryModel::getAllCategories();

        foreach ($categories as $category) {
            $selected = ($category['id_category'] == $selectedCategory) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($category['id_category']) . '" ' . $selected . '>' . htmlspecialchars($category['description']) . '</option>';
        }
    }
}
