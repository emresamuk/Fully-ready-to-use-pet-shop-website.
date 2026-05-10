@extends('layouts.app')

@section('content')
<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>Siparişi Tamamla</h2>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="form_container">
                    <form action="{{ url('/checkout/complete') }}" method="POST">
                        @csrf
                        <h5>Teslimat Bilgileri [cite: 34, 46]</h5>
                        <div><input type="text" name="full_name" value="{{ auth()->user()->name }}" placeholder="Ad Soyad" required /></div>
                        <div><input type="text" name="address" value="{{ auth()->user()->address }}" placeholder="Adres" required /></div>
                        
                        <h5 class="mt-4">Ödeme Bilgileri [cite: 46]</h5>
                        <div><input type="text" name="card_number" placeholder="Kredi Kartı Numarası" required /></div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="expiry" placeholder="AA/YY" required />
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="cvv" placeholder="CVV" required />
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <strong>Mevcut Bakiyeniz:</strong> ${{ auth()->user()->balance ?? 0 }} 
                            <p class="small mb-0">* Ödeme sırasında varsa önce bakiyeniz kullanılacaktır. </p>
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-3">Ödemeyi Yap ve Siparişi Ver</button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="box p-3 shadow-sm">
                    <h5>Sipariş Özeti [cite: 45]</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Ürün Toplamı:</span>
                        <span>$100</span>
                    </div>
                    <div class="d-flex justify-content-between text-success">
                        <span>Kullanılan Bakiye:</span>
                        <span>-$20</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between font-weight-bold">
                        <span>Ödenecek Tutar:</span>
                        <span>$80</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection