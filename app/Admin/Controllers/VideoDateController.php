<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\VideoDate;

class VideoDateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '視訊約會時間設定';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new VideoDate);

        //$grid->column('id', __('ID'))->sortable();
        $grid->column('datetime', __('視訊約會時間'))->display(function($datetime){
            return date('Y/m/d H:i', strtotime($datetime)).' ~ '.date('Y/m/d H:i', strtotime($datetime)+1*60*30);
        });
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->filter(function($filter){
            $filter->disableIdFilter();
        });
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
        $show = new Show(VideoDate::findOrFail($id));

        //$show->field('id', __('ID'));
        $show->field('datetime', '視訊約會時間');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new VideoDate);

        //$form->display('id', __('ID'));
        $form->datetime('datetime', __('視訊約會時間'));
      
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
