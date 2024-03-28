<hr class="dashes hidden-md hidden-lg" />

<div class="row message-list-item {{ $message->user_id ? 'message-seller' : 'message-buyer message-me' }}">
  <div class="col-md-2 pr-1">
    @if ($message->user_id)
      <div class="message-user-info visible-md visible-lg">
        <div class="message-user-name" title="seller">
          {{ $message->shop ? $message->shop->name : trans('theme.store') }}
        </div>

        <div class="message-date small">
          {{ $message->created_at->toDayDateTimeString() }}
        </div>
      </div>
    @else
      <div class="message-user-info hidden-md hidden-lg pull-right">
        <div class="message-user-name" title="me">@lang('theme.me')</div>
      </div>
    @endif
  </div> <!-- .col-md-2 -->

  <div class="col-md-8">
    <div class="message-content-wrapper">
      <div class="message-content">
        <h5>{{ $message->subject }}</h5>
        {{ $message->message }}
      </div>

      <div class="message-date small hidden-md hidden-lg {{ $message->customer_id ? 'pull-right' : '' }}">{{ $message->created_at->toDayDateTimeString() }}</div>

      @if ($attachment = optional($message->attachments)->first())
        <a href="{{ get_storage_file_url($attachment->path, 'original') }}" class="pull-right message-attachment" target="_blank" rel="noopener">
          <img src="{{ get_storage_file_url($attachment->path, 'tiny') }}" class="img-sm thumbnail">
        </a>
      @endif
    </div>
  </div> <!-- .col-md-8 -->

  <div class="col-md-2 pl-1">
    @unless ($message->user_id)
      <div class="message-user-info visible-md visible-lg">
        <div class="message-user-name" title="me">@lang('theme.me')</div>
        <div class="message-date small">{{ $message->created_at->toDayDateTimeString() }}</div>
      </div>
    @endunless
  </div> <!-- .col-md-2 -->
</div>

{{-- Replies --}}
@foreach ($message->replies->sortBy('created_at') as $msg)
  <div class="row message-list-item {{ $msg->customer_id ? 'message-buyer message-me' : 'message-seller' }}">
    <div class="col-md-2 pr-1">
      @if ($msg->customer_id)
        <div class="message-user-info hidden-md hidden-lg">
          <div class="message-user-name pull-right" title="me">@lang('theme.me')</div>
        </div>
      @else
        <div class="message-user-info">
          <div class="message-user-name pull-left" title="seller">
            {{ $message->shop ? $message->shop->name : trans('theme.store') }}
          </div>
          <div class="message-date small  visible-md visible-lg">
            {{ $msg->created_at->toDayDateTimeString() }}
          </div>
        </div>
      @endif
    </div> <!-- .col-md-2 -->

    <div class="col-md-8">
      <div class="message-content-wrapper">

        <p class="message-content {{ $msg->customer_id ? 'text-right' : '' }}" style="width: 100%;">{{ $msg->reply }}</p>

        <div class="message-date small hidden-md hidden-lg {{ $msg->customer_id ? 'pull-right' : '' }}">{{ $msg->created_at->toDayDateTimeString() }}</div>

        @if ($attachment = optional($msg->attachments)->first())
          <a href="{{ get_storage_file_url($attachment->path, 'original') }}" class="pull-right message-attachment" target="_blank" rel="noopener">
            <img src="{{ get_storage_file_url($attachment->path, 'tiny') }}" class="img-sm thumbnail">
          </a>
        @endif
      </div>
    </div> <!-- .col-md-8 -->

    <div class="col-md-2 pl-1 visible-md visible-lg">
      @if ($msg->customer_id)
        <div class="message-user-info">
          <div class="message-user-name" title="me">@lang('theme.me')</div>
          <div class="message-date small">{{ $msg->created_at->toDayDateTimeString() }}</div>
        </div>
      @endif
    </div> <!-- .col-md-2 -->
  </div> <!-- .row .message-list-item -->
@endforeach

<!-- Reply the conversation -->
<div class="row message-list-item mt-3 mb-5">
  <div class="col-md-2 pr-1">
  </div> <!-- .col-md-2 -->
  <div class="col-md-8">
    {!! Form::open(['route' => ['message.reply', $message], 'files' => true, 'id' => 'conversation-form', 'data-toggle' => 'validator']) !!}
    <div class="form-group">
      {!! Form::textarea('reply', null, ['class' => 'form-control form-control flat', 'placeholder' => trans('theme.placeholder.message'), 'rows' => '3', 'maxlength' => 500, 'required']) !!}
      <div class="help-block with-errors"></div>
    </div>
    {!! Form::button(trans('theme.button.send_message'), ['type' => 'submit', 'class' => 'btn btn-info pull-right py-2 px-5']) !!}
    {!! Form::close() !!}
  </div> <!-- .col-md-8 -->
  <div class="col-md-2 pl-1">
  </div> <!-- .col-md-2 -->
</div> <!-- .row .message-list-item -->
