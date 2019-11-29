<?php
/**
 * Upload
 *
 * @author dandelion <web.dandelion@gmail.com>
 */
class App_Admin_Product_Upload extends Controller
{
    CONST DIR_PICTURES_L = 'product/l';
    CONST DIR_PICTURES_S = 'product/s';
    CONST DIR_PICTURES_X = 'product/x';
    CONST DIR_PICTURES_TEMP = 'product/temp';

    const PICTURE_WIDTH = 300;
    const PICTURE_HEIGHT = 300;

    const PICTURE_WIDTH_X = 650;
    const PICTURE_HEIGHT_X = 650;

    function init()
    {

    }

    function indexAction(array $params)
    {
        $product_id = $_POST['id'];
        $product = $this->model->product->getById($product_id);

        if (!empty($_FILES))
        {
            $form = $this->load->form('admin/product/album');
            if ($form->isSubmit() && $form->isValid())
            {
                /**
                 * Ресайзим и сохраняем
                 */
                $data = new Entity($form->getData());
                $image = $this->model->image->load($data->Filedata->tmp_name);
                $filename = $product_id.substr(uniqid(),-6).'.jpg';
                $pathBig   = DIR_IMAGES.'/'.self::DIR_PICTURES_L.'/'.$filename;
                $pathSmall = DIR_IMAGES.'/'.self::DIR_PICTURES_S.'/'.$filename;
                $pathSmallX = DIR_IMAGES.'/'.self::DIR_PICTURES_X.'/'.$filename;
                // масштабируем и сохраняем изображения
                $saved1 = $image->shrink(1600,1200)->save($pathBig);
//                $image = $this->model->image->load($data->Filedata->tmp_name);
                $saved2 = $image->framing(self::PICTURE_WIDTH,self::PICTURE_HEIGHT)->save($pathSmall);
                $image = $this->model->image->load($data->Filedata->tmp_name);
                $saved2X = $image->framing(self::PICTURE_WIDTH_X,self::PICTURE_HEIGHT_X)->save($pathSmallX);

                if ($saved1 && $saved2 && $saved2X)
                {
                    $product = $this->model->product->getById($product_id);
                    $this->model->product->edit(array(
                        'album'=>($product->album ? $product->album.'|':'').$filename
                    ),$product_id);
                    echo('ok');
                }
                else
                {
                    echo('Upload error.');
                }
            }
            else echo(nl2br($form->data->field[0]['error']));
        }
        else echo('Attach the file. Maximal size - '.ini_get('upload_max_filesize'));
    }
}