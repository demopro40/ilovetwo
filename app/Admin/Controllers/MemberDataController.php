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
        $grid->column('identity', __('帳號(身分證)'))->width(100);
        $grid->column('phone', __('密碼(手機號)'))->width(100);
        $grid->column('email', __('email'))->width(100);
        $grid->column('gender', __('性別'))->radio([
            'm' => '男',
            'f' => '女',
        ]);
        $grid->column('consultant', __('顧問'));
        $grid->column('data_url', __('資料連結'))->width(100);
        $grid->column('data_url_simple', __('資料連結刪減版'))->width(100);
        $grid->column('plan', __('方案別'));
        $grid->column('describe', __('此人描述'));
        $grid->column('like_trait', __('喜歡類型'));
        $grid->column('pause_push', __('暫停推播(填L)'));
        $grid->column('prohibition', __('人數約滿(填N)'));
        $grid->column('give_phone', __('不給手機號(填N)'));
        //$grid->column('created_at', __('建立時間'));
        // $grid->column('updated_at', __('更新時間'));

        $grid->column('live_place', __('居住地'));
        $grid->column('birth_place', __('出身地'));
        $grid->column('age', __('年次'));
        $grid->column('job', __('職業'));
        $grid->column('height', __('身高'));
        $grid->column('weight', __('體重'));
        $grid->column('income', __('收入'));
        $grid->column('o_age', __('要求年次'));
        $grid->column('o_job', __('要求職業'));
        $grid->column('o_height', __('要求身高'));
        $grid->column('o_weight', __('要求體重'));
        $grid->column('o_income', __('要求收入'));

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->equal('username', '會員名稱');
            $filter->equal('identity', '身分證');
            $filter->equal('phone', '手機號');
            $filter->equal('gender', __('性別'))->radio(['m' => '男','f'=>'女']);
            $filter->equal('consultant', '顧問');

        });

        $grid->disableExport();
        $grid->disableColumnSelector();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            //$actions->disableEdit();
            $actions->disableDelete();
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
        $form->text('pause_push', __('暫停推播'));
        $form->text('describe', __('此人描述'));
        $form->text('like_trait', __('喜歡類型'));
        $form->text('prohibition', __('人數約滿'));
        $form->text('give_phone', __('不給手機號'));

        $form->html("<hr>");

        $form->text('live_place', __('居住地'));
        $form->text('birth_place', __('出身地'));

        $form->radio('age', __('年次'))
            ->options([
                '2000後' => '2000後',
                '1996~2000'=> '1996~2000',
                '1991~1995'=> '1991~1995',
                '1986~1990'=> '1986~1990',
                '1981~1985'=> '1981~1985',
                '1976~1980'=> '1976~1980',
                '1971~1975'=> '1971~1975',
                '1966~1970'=> '1966~1970',
                '1961~1965'=> '1961~1965',
                '1961前'=> '1961前',
            ]);

        $form->text('job', __('職業'));

        $form->radio('height', __('身高'))
            ->options([
                '150以下' => '150cm以下',
                '150~155'=> '150~155cm',
                '156~160'=> '156~160cm',
                '161~165'=> '161~165cm',
                '166~170'=> '166~170cm',
                '171~175'=> '171~175cm',
                '176~180'=> '176~180cm',
                '181~185'=> '181~185cm',
                '186~190'=> '186~190cm',
                '190以上'=> '190cm以上',
            ]);
        $form->radio('weight', __('體重'))
        ->options([
            '35以下' => '35kg以下',
            '35~40'=> '35~40kg',
            '40~45'=> '40~45kg',
            '46~50'=> '46~50kg',
            '51~55'=> '51~55kg',
            '56~60'=> '56~60kg',
            '61~65'=> '61~65kg',
            '66~70'=> '66~70kg',
            '71~75'=> '71~75kg',
            '76~80'=> '76~80kg',
            '81~85'=> '81~85kg',
            '86~90'=> '86~90kg',
            '91~95'=> '91~95kg',
            '96~100'=> '96~100kg',
            '100以上'=> '100kg以上',
        ]);
        $form->text('income', __('收入'));
        $form->html("<hr>");
        $form->radio('o_age', __('要求年次'))
            ->options([
                '2000後' => '2000後',
                '1996~2000'=> '1996~2000',
                '1991~1995'=> '1991~1995',
                '1986~1990'=> '1986~1990',
                '1981~1985'=> '1981~1985',
                '1976~1980'=> '1976~1980',
                '1971~1975'=> '1971~1975',
                '1966~1970'=> '1966~1970',
                '1961~1965'=> '1961~1965',
                '1961前'=> '1961前',
            ]);

        $form->text('o_job', __('要求職業'));

        $form->radio('o_height', __('要求身高'))
            ->options([
                '150以下' => '150cm以下',
                '150~155'=> '150~155cm',
                '156~160'=> '156~160cm',
                '161~165'=> '161~165cm',
                '166~170'=> '166~170cm',
                '171~175'=> '171~175cm',
                '176~180'=> '176~180cm',
                '181~185'=> '181~185cm',
                '186~190'=> '186~190cm',
                '190以上'=> '190cm以上',
            ]);

        $form->radio('o_weight', __('要求體重'))
        ->options([
            '35以下' => '35kg以下',
            '35~40'=> '35~40kg',
            '40~45'=> '40~45kg',
            '46~50'=> '46~50kg',
            '51~55'=> '51~55kg',
            '56~60'=> '56~60kg',
            '61~65'=> '61~65kg',
            '66~70'=> '66~70kg',
            '71~75'=> '71~75kg',
            '76~80'=> '76~80kg',
            '81~85'=> '81~85kg',
            '86~90'=> '86~90kg',
            '91~95'=> '91~95kg',
            '96~100'=> '96~100kg',
            '100以上'=> '100kg以上',
        ]);
        $form->text('o_income', __('要求收入'))->help('例如: 想找月薪五萬以上請填 60，想找年薪百萬以上請填 100');

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
