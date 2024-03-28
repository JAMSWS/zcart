<div class="modal-dialog modal-sm">
  <div class="modal-content">
    {!! Form::open(['route' => 'admin.account.shop.updateAccountNumber', 'id' => 'form', 'data-toggle' => 'validator']) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      {{ trans('app.form.form') }}
    </div>
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('account_number', trans('app.form.account_number'), ['class' => 'with-help']) !!}
        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('help.shop_account_number') }}"></i>
        {!! Form::text('account_number',$account_number , ['class' => 'form-control', 'id' => 'shop_account_number', 'placeholder' => trans('app.placeholder.account_number')]) !!}
        <div class="help-block with-errors"></div>
      </div>
    </div>
    <div class="modal-footer">
      {!! Form::submit(trans('app.form.save'), ['class' => 'btn btn-flat btn-new']) !!}
    </div>
    {!! Form::close() !!}
  </div> <!-- / .modal-content -->
</div> <!-- / .modal-dialog -->
