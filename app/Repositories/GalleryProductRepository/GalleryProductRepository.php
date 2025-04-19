<?php
namespace App\Repositories\GalleryProductRepository;

use App\Models\GalleryProduct;
use App\Repositories\BaseRepository;
use App\Repositories\GalleryProductRepository\GalleryProductInterfaceRepository;

class GalleryProductRepository extends BaseRepository implements GalleryProductInterfaceRepository
{
    public function getModel()
    {
        return \App\Models\GalleryProduct::class;
    }

    public function getGallery($product_id)
    {
        $gallery_image = $this->model->where("product_id", $product_id)->get();
        return $gallery_image;
    }

    public function insertGallery($product_id, $get_images)
    {
        // $get_images = $request->file('file');

        if ($get_images) {
            foreach ($get_images as $get_image) {
                $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
                $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
                $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
                $get_image->move('public\fontend\assets\img\product', $new_image);

                $gallery = new GalleryProduct();
                $gallery['product_id'] = $product_id;
                // $gallery['gallery_product_name'] = $image_name;
                $gallery['gallery_image_product'] = $new_image;
                // $gallery['gallery_product_content'] = "Ảnh này chưa có nội dung !";
                $gallery->save();
            }
        }
    }

    public function updateImageGallery($gallery_id, $get_image)
    {
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName(); /* Lấy Tên File */
            $image_name = current(explode('.', $get_image_name)); /* VD Tên File Là nhan.jpg thì hàm explode dựa vào dấm . để phân tách thành 2 chuổi là nhan và jpg , còn hàm current để chuổi đầu , hàm end thì lấy cuối */
            $new_image = $image_name . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); /* getClientOriginalExtension() hàm lấy phần mở rộng của ảnh */
            $get_image->move('public/fontend/assets/img/product', $new_image);
            $gallery = GalleryProduct::where('gallery_id', $gallery_id)->first();
            $gallery['gallery_image_product'] = $new_image;
            $gallery->save();
        }
    }

    public function updateContentGallery($gallery_id, $gallery_text, $type)
    {
        $gallery_image = $this->find($gallery_id);
        if ($type == "Tên Ảnh") {
            $gallery_image['gallery_image_name'] = $gallery_text;
        } else if ($type == "Nội Dung Ảnh") {
            $gallery_image['gallery_image_content'] = $gallery_text;
        }
        $gallery_image->save();
    }

    public function deleteGallery($gallery_id)
    {
        // $gallery_product = GalleryProduct::where('gallery_id', $gallery_id)->first();
        // $gallery_product->delete();
        $this->delete($gallery_id);
    }

}