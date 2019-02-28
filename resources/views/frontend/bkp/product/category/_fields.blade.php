<div class="card mt-3 mb-3">
    <div class="card-header">Basic Details</div>
    <div class="card-body">
        @include("admin.forms.text",['name'=> 'name','label' => 'Name','value'=> $model->name ?? ""])
        @include("admin.forms.text",['name'=> 'slug','label' => 'Category Slug','value'=> $model->slug ?? ""])
        
        @include("admin.forms.select",['name'=> 'parent_id','label' => 'Parent Category','value'=>$model->parent_id ?? '',
        'options' => $categoryOptions
        ])                        
    </div>
</div>
<div class="card mt-3 mb-3">
    <div class="card-header">SEO</div>
    <div class="card-body">
        @include("admin.forms.text",['name'=> 'meta_title','label' => 'Meta Name',
        "value"=>$model->meta_title??''])
        @include('admin.forms.textarea',['name' => 'meta_description','label' => 'Meta Description','value'=>$model->meta_description ?? ""])                        
    </div>
</div>