<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Restaurant;

class RestaurantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '餐廳地點設定';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Restaurant);

        //$grid->column('id', __('ID'))->sortable();
        $grid->column('place', __('餐廳地點'));
        $grid->column('url', __('餐廳介紹連結'));
        $grid->column('qualification', __('黃金會員限定'))->display(function($data){
            if($data == 'yes'){
                return '是';
            }
            return '否';
        });
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            //$actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                //$batch->disableDelete();
            });
        });
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Restaurant::findOrFail($id));

        //$show->field('id', __('ID'));

        $show->panel()
        ->tools(function ($tools) {
            // $tools->disableEdit();
            // $tools->disableList();
            // $tools->disableDelete();
        });;
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Restaurant);

        //$form->display('id', __('ID'));
        $form->text('place', __('餐廳地點'));
        $form->text('url', __('餐廳介紹連結'));
        $form->radio('qualification', __('黃金會員限定'))->options(['yes'=>'是','no'=>'否']);
        // $form->display('created_at', __('建立時間'));
        // $form->display('updated_at', __('更新時間'));
        $form->tools(function (Form\Tools $tools) {
            //$tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
