<?php
namespace App\Repositories\SliderRepository;

use App\Repositories\RepositoryInterface;

interface SliderInterfaceRepository extends RepositoryInterface
{
    public function getAllByPaginate($value);
    public function insert_slider($data, $get_image);
    public function update_slider($data, $get_image);  
    public function find($id);
    public function un_active($id, $status);
    public function delete_slider($slider_id);

    public function getListDelete();
    public function findSliderDelete($id, $type);
}