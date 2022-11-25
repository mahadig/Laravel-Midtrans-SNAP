<x-frontend-layout>

    <div class="container pt-5">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div >
                        <ul class="mt-3 ps-3 list-disc list-inside text-sm text-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pay') }}" method="post">
                    @csrf
                    @foreach ($items as $item)
                        <div class="form-check">
                            <input class="form-check-input" name="products[]" type="checkbox" value="{{ $item['id'] }}"
                                id="{{ $item['id'] }}">
                            <label class="form-check-label" for="{{ $item['id'] }}">
                                {{ $item['name'] }} - Harga Rp. {{ $item['price'] }}
                            </label>
                        </div>
                    @endforeach


                    <button id="pay-button" class="btn btn-success mt-3">Lanjutkan ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>


</x-frontend-layout>
