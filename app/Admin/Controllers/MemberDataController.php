<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\MemberData;

class MemberDataController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '會員資料';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MemberData);

        $grid->model()->orderBy('id', 'desc');
        //$grid->column('id', __('ID'))->rsortable();
        $grid->column('username', __('會員名稱'));
        $grid->column('identity', __('帳號(身分證)'));
        $grid->column('phone', __('密碼(手機號)'));
        $grid->column('email', __('email'))->width(150);
        $grid->column('gender', __('性別'))->radio([
            'm' => '男',
            'f' => '女',
        ]);
        $grid->column('consultant', __('顧問'));
        $grid->column('data_url', __('資料連結'))->width(150);
        $grid->column('data_url_simple', __('資料連結刪減版'))->width(150);
        $grid->column('plan', __('方案別'));
        $grid->column('live_place', __('居住地'));
        $grid->column('birth_place', __('出身地'));
        $grid->column('in_love', __('脫單紀錄'));
        $grid->column('describe', __('此人描述'));
        $grid->column('like_trait', __('喜歡類型'));
        $grid->column('frequency', __('主約次數'));
        //$grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->equal('username', '會員名稱');
            $filter->equal('user_id', '身分證');
            $filter->equal('password', '手機號');
            $filter->equal('gender', __('性別'))->radio(['m' => '男','f'=>'女']);
            $filter->equal('consultant', '顧問');

        });

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
        $show = new Show(MemberData::findOrFail($id));

        $show->field('id', __('ID'));
      
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
        $form = new Form(new MemberData);

        //$form->display('id', __('ID'));
        $form->text('username', __('會員名稱'));
        $form->text('identity', __('身分證'));
        $form->text('phone', __('手機號'));
        $form->text('email', __('email'));
        $form->radio('gender', __('性別'))->options(['m'=>'男','f'=>'女']);
        $form->text('consultant', __('顧問'));
        $form->text('data_url', __('資料連結'));
        $form->text('data_url_simple', __('資料連結刪減版'));
        $form->text('plan', __('方案別'));
        $form->text('live_place', __('居住地'));
        $form->text('birth_place', __('出身地'));
        $form->text('in_love', __('脫單紀錄'));
        $form->text('describe', __('此人描述'));
        $form->text('like_trait', __('喜歡類型'));
        $form->text('frequency', __('主約次數'));
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
