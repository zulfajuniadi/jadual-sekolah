@extends('frontend')

@php
    $count = App\Models\Child::withoutGlobalScope(App\Models\Scopes\MyChildScope::class)->count();
    $avatars = App\Models\Child::withoutGlobalScope(App\Models\Scopes\MyChildScope::class)->whereNotNull('avatar_config')->inRandomOrder()->take(6)->get();
@endphp

@section('content')
    <!-- Masthead -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Membantu Ibu Bapa <br> Mengharungi PdPR</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto d-none">
                    <form>
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="email" class="form-control form-control-lg" placeholder="Enter your email...">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <p class="attribution">
            Photo by Julia M Cameron from Pexels
        </p>
    </header>
    
    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <h2 class="mb-5">
                Pantau kelas anak anda dengan 3 langkah mudah:
            </h2>
            <div class="row pt-3">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon">
                            <div class="mx-auto">
                                <img src="/avatar/3.svg" alt="" style="width:100px;height:100px;border-radius:50px;">
                            </div>
                        </div>
                        <h3>Daftar anak anda</h3>
                        <p class="lead mb-0">
                            Masukkan nama anak anda dan avatarnya di platform kami.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <div class="mx-auto">
                                <img src="/images/logo.png" alt="" style="width:100px;height:100px;">
                            </div>
                        </div>
                        <h3>Tambah jadual waktu</h3>
                        <p class="lead mb-0">
                            Tambah jadual waktu kelas anak anda bersama pautan Google classroom.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-paper-clip m-auto"></i>
                        </div>
                        <h3>Pautan jadual waktu</h3>
                        <p class="lead mb-0">
                            Simpan pautan jadual waktu di Home Screen peranti anak anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Image Showcases -->
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/schedule.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Senang Untuk Digunakan</h2>
                    <p class="lead mb-0">Mudah difahami dan senang digunakan untuk pelajar sekolah rendah, menengah, mahupun universiti.</p>
                    <a target="_blank" href="/s/zulfa-juniadi">Contoh Jadual</a>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/attandance.jpg');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>Pantau Kehadiran</h2>
                    <p class="lead mb-0">Pantau kehadiran anak anda secara online. Boleh tapis data menggunakan tarikh dan nama.</p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/points.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Bintang Pencapaian</h2>
                    <p class="lead mb-0">Setiap kali anak anda hadir ke kelas, satu <i class="fa fa-star" style="color:gold"></i> akan diberikan. </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <div class="row">
                @foreach($avatars as $avatar)
                <div class="col">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img width="120px" height="120px" class="img-fluid rounded-circle mb-3" src="/avatar/{{$avatar->id}}.svg" alt="">
                    </div>
                </div>
                @endforeach
            </div>
            <h2 class="mt-5">Lebih {{$count}} pelajar telah didaftarkan</h2>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">Sedia untuk mula? Daftar Sekarang!</h2>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <div class="form-row">
                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3 mx-auto">
                            <a href="/app/register" class="btn btn-block btn-lg btn-primary">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection