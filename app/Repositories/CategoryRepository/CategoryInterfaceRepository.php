<?php
namespace App\Repositories\CategoryRepository;

use App\Repositories\RepositoryInterface;

interface CategoryInterfaceRepository extends RepositoryInterface
{
    public function getAllByPaginate($value);
    public function insertCategory($data);
    public function updateCategory($data);
    public function deleteCategory($id);
    public function findCategoryId($id);
    public function un_active_category($id, $status);

    public function deleteAndRestore($id, $type);
    public function getBin();
}