<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\PushFactor;

class PushFactorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '推播篩選設定';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PushFactor);
        //$grid->column('id', __('ID'))->sortable();
        $grid->column('username', __('會員名稱'));
        $grid->column('age', __('年次'));
        $grid->column('job', __('職業'));
        $grid->column('height', __('身高'));
        $grid->column('weight', __('體重'));
        $grid->column('income', __('年收入'));
        $grid->column('o_age', __('要求年次'));
        $grid->column('o_job', __('要求職業'));
        $grid->column('o_height', __('要求身高'));
        $grid->column('o_weight', __('要求體重'));
        $grid->column('o_income', __('要求年收入'));
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));
        $grid->disableExport();
        $grid->disableColumnSelector();

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->equal('username', '會員名稱');
            $filter->between('age', '年次');
            $filter->like('job', '職業');
            $filter->between('height', '身高');
            $filter->between('weight', '體重');
            $filter->between('income', '年收入');
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            $actions->disableDelete();
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append("<button class='member-push' id='member_push'>前往會員推播表</button>");
        });

        $html = <<<html
            <style>
                .member-push{
                    background-color:purple;
                    padding:5px 10px; 
                    color:white;
                }
            </style>
            <script>
                $("#member_push").click(function(){
                    location.href="/admin/AppointmentList"
                });
            </script>
html;
        $grid->html($html);

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
        $show = new Show(PushFactor::findOrFail($id));

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
        $form = new Form(new PushFactor);

        //$form->display('id', __('ID'));
        $form->text('username', __('會員名稱'));
        $form->text('age', __('年次'));
        $form->text('job', __('職業'));
        $form->text('height', __('身高'));
        $form->text('weight', __('體重'));
        $form->text('income', __('年收入'));
        $form->text('o_age', __('要求年次'));
        $form->text('o_job', __('要求職業'));
        $form->text('o_height', __('要求身高'));
        $form->text('o_weight', __('要求體重'));
        $form->text('o_income', __('要求年收入'));
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
