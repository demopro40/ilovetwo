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

        $grid->model()->orderBy('id', 'desc');
        $grid->column('username', __('會員名稱'))->display(function($data){
            $result = '';
            $val = MemberData::where('username', $data)->get()->toArray();
            if(empty($val)){
                return $data;
            }
            $result .= $val[0]['username']."(出生:".$val[0]['birth_place'].")".
            "(居住:".$val[0]['live_place'].")".
            "(".$val[0]['describe'].")".
            "(喜歡類型:".$val[0]['like_trait'].")";
            return $result;
        });
        $grid->column('appointment_username', __('排約會員'))->width(500);
        $grid->column('appointment_user_new', __('要推播的會員'))->display(function($data){
            $ary = explode('、', $data);
            $result = '';
            foreach($ary as $value){
                $val = MemberData::where('username', $value)->get(['username','live_place','birth_place','describe'])->toArray();
                if(!empty($val)){
                    $result .= $val[0]['username']."(居住:".$val[0]['live_place'].")".
                    "(出生:".$val[0]['birth_place'].")".
                    "(".$val[0]['describe'].")".
                    "、";
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
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                //$batch->disableDelete();//批次刪除
            });
        });

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('username', '會員名稱');
            $filter->where(function ($query) {
                $input = $this->input;
                $data = MemberData::where('plan',$input)->get(['username'])->toArray();
                $ary = [];
                foreach($data as $value){
                    array_push($ary, $value['username']);
                }
                $query->whereIn('username', $ary);
            }, '方案別');
            $filter->where(function ($query) {
                $input = $this->input;
                $data = MemberData::where('gender',$input)->get(['username'])->toArray();
                $ary = [];
                foreach($data as $value){
                    array_push($ary, $value['username']);
                }
                $query->whereIn('username', $ary);
            }, '性別')->radio(['m' => '男','f'=>'女']);
            $filter->where(function ($query) {
                $input = $this->input;
                $data = MemberData::where('consultant',$input)->get(['username'])->toArray();
                $ary = [];
                foreach($data as $value){
                    array_push($ary, $value['username']);
                }
                $query->whereIn('username', $ary);
            }, '顧問');
        });

        $grid->batchActions(function ($batch) { //php artisan admin:action Member\AddMember --name="新增推播" --grid-batch    
            //$batch->add(new AddMember());
            //$batch->add(new PushMember());
            //$batch->add(new BackMember());
        });
        $grid->tools(function (Grid\Tools $tools) { //php artisan admin:action Member\AddMember --name="新增推播"   
            // $tools->append(new AddMember());
            // $tools->append(new PushMember());
            //$tools->append(new BackMember());
            $tools->append("<button class='add-member' id='add_member'>新增推播</button>");
            $tools->append("<button class='push-member' id='push_member'>確認推播</button>");
            $tools->append("<button class='gold-push-member' id='gold_push_member'>黃金會員推播</button>");
            $tools->append("<button class='invite-insert-push' id='invite_insert_push'>主約加入被約推播</button>");
        });

        $html = <<<html
            <style>
                .add-member{
                    background-color:green;
                    padding:5px 10px; 
                    color:white;
                }
                .push-member{
                    background-color:green;
                    padding:5px 10px; 
                    color:white;
                }
                .gold-push-member{
                    background-color:blue;
                    padding:5px 10px; 
                    color:white;
                }
                .invite-insert-push{
                    background-color:orange;
                    padding:5px 10px; 
                    color:white;
                }
                .back-member{
                    background-color:green;
                    padding:5px 10px; 
                    color:white;
                }
            </style>
            <script>
                $("#add_member").click(function(){
                    $.post('/api/v1/addMember',
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
                $("#push_member").click(function(){

                    var password = prompt("請輸入密碼", " ");
                    if(password == '654321'){
                        $.post('/api/v1/pushMember',
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
                    }else{
                        alert('密碼輸入錯誤');
                    }

                });
                $("#gold_push_member").click(function(){
                    $.post('/api/v1/goldPushMember',
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
                $("#invite_insert_push").click(function(){
                    $.post('/api/v1/inviteInsertPush',
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
        // if($form->isCreating()){
        //     $form->text('username', __('會員名稱'));
        // };
        // if($form->isEditing()){
        //     $form->display('username', __('會員名稱'));
        // };
        $form->text('username', __('會員名稱'));
        $form->textarea('appointment_username', __('排約會員'));
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
