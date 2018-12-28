<div class="card mt-3 mb-3">
    <div class="card-header">Basic Details</div>
    <div class="card-body">
        @include("admin.forms.text",['name'=> 'name','label' => 'Name','value'=> $model->name ?? ""])
        @include("admin.forms.text",['name'=> 'discount','label' => 'Discount','value'=> $model->discount ?? ""])
        @include("admin.forms.select",['name'=> 'discount_type','label' => 'Discount type','value'=>$model->discount_type ?? '',
        'options' => ['PERCENTAGE' => 'PERCENTAGE', 'FIXED' => 'FIXED']
        ])
    </div>
</div>