<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Shop';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Shop());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('category.name', __('Category Name'));
        $grid->column('image', __('Image'))->image();
        $grid->column('name', __('Name'));
        $grid->column('description', __('Description'));
        $grid->column('min_price', __('Min price'))->sortable();
        $grid->column('max_price', __('Max price'))->sortable();
        $grid->column('opening_time', __('Opening time'));
        $grid->column('closing_time', __('Closing time'));
        $grid->column('regular_holiday', __('Regular holiday'));
        $grid->column('postal_code', __('Postal code'));
        $grid->column('address', __('Address'));
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        $grid->filter(function($filter) {
            $filter->like('name', '店舗名');
            $filter->like('description', '店舗説明');
            $filter->between('max_price', '金額');
            $filter->in('category_id', 'カテゴリー')->multipleSelect(Category::all()->pluck('name', 'id'));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Shop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category.name', __('Category Name'));
        $show->field('image', __('Image'))->image();
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('min_price', __('Min price'));
        $show->field('max_price', __('Max price'));
        $show->field('opening_time', __('Opening time'));
        $show->field('closing_time', __('Closing time'));
        $show->field('regular_holiday', __('Regular holiday'));
        $show->field('postal_code', __('Postal code'));
        $show->field('address', __('Address'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Shop());

        $form->select('category_id', __('Category Name'))->options(Category::all()->pluck('name', 'id'));
        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->number('min_price', __('Min price'));
        $form->number('max_price', __('Max price'));
        $form->time('opening_time', __('Opening time'))->default(date('H:i:s'));
        $form->time('closing_time', __('Closing time'))->default(date('H:i:s'));
        $form->text('regular_holiday', __('Regular holiday'));
        $form->text('postal_code', __('Postal code'));
        $form->text('address', __('Address'));
        $form->image('image', __('Image'));

        return $form;
    }
}
