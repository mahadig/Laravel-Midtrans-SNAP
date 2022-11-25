<x-frontend-layout>

    <div class="container pt-5">
        <div class="row">
            <div class="col-12">
                Rincian Pesanan
                <ul class="list-group">
                    @foreach ($order['items'] as $item)
                        <li class="list-group-item">{{ $item['name'] }} @ {{ $item['price'] }} x {{ $item['quantity'] }}
                            = {{ $item['quantity'] * $item['price'] }}</li>
                    @endforeach
                    <li class="list-group-item">
                        <strong>Total Pesanan {{ $order['gross_amount'] }}</strong>
                    </li>
                </ul>
                <button id="pay-button" class="btn btn-success mt-3">Bayar</button>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-ScAl8o0Wr5wVQZO9"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $order['snap_token'] }}', {
                onPending: function(result) {

                    if (result.pdf_url) {
                        $('#pay-guide').removeClass('d-none');
                        $('#pay-guide').attr('href', result.pdf_url);
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('{{ url()->current() }}', result);
                },
            });
        };
    </script>

</x-frontend-layout>
