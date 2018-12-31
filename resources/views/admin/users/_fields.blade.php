<div class="card mt-3 mb-3">
    <div class="card-header">Basic Details</div>
    <div class="card-body">
        @include("admin.forms.text",['name'=> 'full_name','label' => 'Name','value'=> $model->full_name ?? ""])
        @include("admin.forms.text",['name'=> 'email','label' => 'Email','value'=> $model->email ?? ""])
        @include("admin.forms.text",['name'=> 'mobile_number','label' => 'Mobile Number','value'=> $model->mobile_number ?? ""])

        @include("admin.forms.select",['name'=> 'role_id','label' => 'Role','value'=>$model->role_id ?? '',
        'options' => $roleOptions
        ])
        @include("admin.forms.select",['name'=> 'group_id','label' => 'Group','value'=>$model->group_id ?? '',
        'options' => $groupOptions
        ])
    </div>
</div>