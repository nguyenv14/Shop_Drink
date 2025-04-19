<?php
namespace App\Repositories\GalleryProductRepository;

use App\Repositories\RepositoryInterface;

interface GalleryProductInterfaceRepository extends RepositoryInterface
{
    public function getGallery($product_id);
    public function insertGallery($product_id, $get_image);
    public function updateImageGallery($gallery_id, $get_image);
    public function updateContentGallery($gallery_id, $gallery_text, $type);
    public function deleteGallery($gallery_id);
}