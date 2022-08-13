<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\AppointmentList;
use App\Models\MemberData;
use App\Admin\Actions\Member\AddMember;
use App\Admin\Actions\Member\PushMember;
use App\Admin\Actions\Member\BackMember;

class AppointmentListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '會員推播表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AppointmentList);
        $grid->column('username', __('會員名稱'))->display(function($data){
            $result = '';
            $val = MemberData::where('username', $data)->get(['username','live_place','birth_place'])->toArray();
            if(empty($val)){
                return $data;
            }
            $result .= $val[0]['username']."(居住:".$val[0]['live_place'].")"."(出生:".$val[0]['birth_place'].")";
            return $result;
        });
        $grid->column('appointment_username', __('排約會員'))->display(function($data){
            // $ary = explode('、', $data);
            // $result = '';
            // foreach($ary as $value){
            //     $val = MemberData::where('username', $value)->get(['username','live_place','birth_place'])->toArray();
            //     $result .= $val[0]['username']."(居住:".$val[0]['live_place'].")"."(出生:".$val[0]['birth_place'].")"."、";
            // }
            // return $result;
            return $data;
        });
        $grid->column('appointment_user_new', __('要推播的會員'))->display(function($data){
            $ary = explode('、', $data);
            $result = '';
            foreach($ary as $value){
                $val = MemberData::where('username', $value)->get(['username','live_place','birth_place'])->toArray();
                if(!empty($val)){
                    $result .= $val[0]['username']."(居住:".$val[0]['live_place'].")"."(出生:".$val[0]['birth_place'].")"."、";
                }
            }
            return $result;
        });
        //$grid->column('appointment_user_latest', __('最新推播的會員'));
        $grid->column('appointment_user_excluded', __('排除的會員'));

        //$grid->disableCreateButton();
        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            //$actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();//批次刪除
            });
        });

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('username', '會員名稱');
        });

        // $html = <<<html
        //     <style>
        //         .add-member{
        //             background-color:green;
        //             padding:5px 10px; 
        //             color:white;
        //         }
        //         .push-member{
        //             background-color:green;
        //             padding:5px 10px; 
        //             color:white;
        //         }
        //         .back-member{
        //             background-color:green;
        //             padding:5px 10px; 
        //             color:white;
        //         }
        //     </style>
        // html;
        // $grid->html($html);
        $grid->batchActions(function ($batch) { //php artisan admin:action Member\AddMember --name="新增推播" --grid-batch    
            $batch->add(new AddMember());
            $batch->add(new PushMember());
            //$batch->add(new BackMember());
        });
        // $grid->tools(function (Grid\Tools $tools) { //php artisan admin:action Member\AddMember --name="新增推播"   
        //     $tools->append(new AddMember());
        //     $tools->append(new PushMember());
        //     $tools->append(new BackMember());
        // });
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
        $show = new Show(AppointmentList::findOrFail($id));

        $show->field('username', '會員名稱');
        $show->field('created_at', __('建立時間'));
        $show->field('updated_at', __('更新時間'));
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
        $form = new Form(new AppointmentList);
        if($form->isCreating()){
            $form->text('username', __('會員名稱'));
        };
        if($form->isEditing()){
            $form->display('username', __('會員名稱'));
        };

        $form->text('appointment_username', __('排約會員'));
        $form->text('appointment_user_new', __('要推播的會員'));
        //$form->text('appointment_user_latest', __('最新推播的會員'));
        $form->text('appointment_user_excluded', __('排除的會員'))->help('輸入會員名稱，兩個以上需加頓號(、)當間隔，例 : sam、luke');

        //$form->ignore([]);

        //$form->saving(function (Form $form) {

            // //dd(request()->input());
           
        //});

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
