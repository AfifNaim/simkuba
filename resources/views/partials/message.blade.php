@if(session()->get('success', false))
    <?php $data = session()->get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $msg }}
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ $data }}
            </div>
        </div>
    @endif
@elseif(session()->get('error', false))
    <?php $data = session()->get('error'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ $msg }}
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                {{ $data }}
            </div>
        </div>
    @endif
@endif
