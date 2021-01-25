@extends(backpack_view('blank'))

@section('content')
<div class="card mb-5">
    <div class="card-header">
        Tips
    </div>
    <div class="card-body">
        <ul class="list-unstyled">
            <li>
                Simpan pautan ini dalam pelayar anak anda: <br>
                <a href="/s/{{backpack_user()->public_slug}}"><?=url('/s/' . backpack_user()->public_slug)?></a> <button data-clipboard-text="<?=url('/s/' . backpack_user()->public_slug)?>" class="btn btn-sm btn-text" id="copy-link"><i class="la la-copy"></i></button> <span id="copy-link-success" class="text-success" style="font-size: 12px; display: none">Telah Copy</span>
            </li>
            <li>
                Masukkan jadual ini ke dalam <a href="https://twitter.com/zuljzul/status/1353760275334221825?s=20" target="_blank">aplikasi kalendar</a> anda: <br>
                <span><?=url('/c/' . backpack_user()->public_slug . '.ical')?></span> <button data-clipboard-text="<?=url('/c/' . backpack_user()->public_slug . '.ical')?>" class="btn btn-sm btn-text" id="copy-ical"><i class="la la-copy"></i></button> <span id="copy-ical-success" class="text-success" style="font-size: 12px; display: none">Telah Copy</span>
            </li>
        </ul>
    </div>
</div>
@include('schedule')
<br>
<br>
@endsection

@push('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
    var linkCb = new ClipboardJS($('#copy-link')[0]);
    linkCb.on('success', function(e) {
        $('#copy-link-success').show();
        setTimeout(function(){
            $('#copy-link-success').hide();
        }, 3000);
    });
    var icalCb = new ClipboardJS($('#copy-ical')[0]);
    icalCb.on('success', function(e) {
        $('#copy-ical-success').show();
        setTimeout(function(){
            $('#copy-ical-success').hide();
        }, 3000);
    });
</script>
@endpush