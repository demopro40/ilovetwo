<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use App\Models\AppointmentRegistration;
use App\Models\Restaurant;

class AppointmentRegistrationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '排約報名表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AppointmentRegistration);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('username', __('排約會員'));
        $grid->column('appointment_user', __('排約對象'));
        $grid->column('type', __('排約類型'));
        $grid->column('chat_option', __('聊天選項'));
        $grid->column('restaurant', __('餐廳地點'));
        $grid->column('datetime', __('排約時段'));
        $grid->column('appointment_respond', __('排約對象回應'))->display(function($data){
            if($data == "noTime"){
                $result = "noTime(時間無法配合，要另約時間)";
                return $result;
            }
            if($data == "delete" ){
                $result = "delete(拒絕邀約)";
                return $result;
            }
            if($data == "noSel" ){
                $result = "noSel(暫不回應)";
                return $result;
            }
            return $data;
        });
        $grid->column('appointment_result', __('排約結果'))->display(function($data){

            if($data == "noTime"){
                $result = "noTime(時間無法配合，要另約時間)";
                return $result;
            }
            if($data == "delete" ){
                $result = "delete(拒絕邀約)";
                return $result;
            }
            if($data == "noSel" ){
                $result = "noSel(暫不回應)";
                return $result;
            }
            if($data == "otherSide"){
                return $data;
            }
            if($data == NULL){
                return NULL;
            }
            
            $data = explode("、", $data);                       
            if($this->type == '視訊約會'){
                $result = date('Y-m-d H:i:s', strtotime($data[0])).'~'.date('H:i:s', strtotime($data[0])+1*30*60);
            }
            if($this->type == '餐廳約會'){
                $result = date('Y-m-d H:i:s', strtotime($data[0])).'~'.date('H:i:s', strtotime($data[0])+1*60*60);
            }

            return $result;
        });
        $grid->column('message', __('訊息'));
        // $grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('username', '排約會員');
            $filter->equal('appointment_user', '排約對象');
        });

        $grid->disableExport();
        $grid->disableColumnSelector();
        //$grid->disableActions();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            //$actions->disableDelete();
        });
        $html = <<<html
            <style>
                .pair_time{
                    background-color:green;
                    padding:5px 10px; 
                    color:white;
                }
            </style>
            <script>
                $("#pair_time").click(function(){
                    $.post('/api/v1/pairTime',
                    {
                        password : "2BGf9RZXDrgJ"
                    },
                    function(data, status){
                        if(status == 'success'){
                            alert('success');
                            location.reload();
                        }else{
                            alert('fail');
                        }
                    });
                });
            </script>
        html;
        $grid->html($html);
        $grid->tools(function (Grid\Tools $tools) {
            //$tools->append("<a href='/date/pair_time' class='btn pair_time'>結果配對</a>");
            $tools->append("<button class='pair_time' id='pair_time'>結果配對</button>");
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
        $show = new Show(AppointmentRegistration::findOrFail($id));

        $show->field('id', __('ID'));
     
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
        $form = new Form(new AppointmentRegistration);

        $form->display('id', __('ID'));
        $form->text('username', __('會員名稱'))->required();
        $form->text('appointment_user', __('排約對象'))->required();
        $form->radio('type', __('排約類型'))->options(['視訊約會' =>'視訊約會', '餐廳約會' =>'餐廳約會'])->required();
        $form->select('chat_option', __('聊天選項'))->options(['請選擇' => '請選擇', '自由聊天' => '自由聊天', '選擇話題聊天' => '選擇話題聊天', '破冰遊戲>聊天' => '破冰遊戲>聊天']);
        $form->text('restaurant', __('餐廳地點'));
        $form->text('datetime', __('選擇的時間'));
        $form->text('appointment_respond', __('排約對象回應'));
        $form->text('appointment_result', __('排約結果'));
        $form->text('message', __('訊息'));
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
