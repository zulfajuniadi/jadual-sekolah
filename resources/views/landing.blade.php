@extends('frontend')
@section('content')
    <!-- Masthead -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Helping Parents Cope With PdPR</h1>
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
            <h1 class="mb-5">
                Monitor your child's home schooling in 3 easy steps:
            </h1>
            <div class="row pt-3">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon">
                            <div class="mx-auto">
                                <img src="/avatar/3.svg" alt="" style="width:100px;height:100px;border-radius:50px;">
                            </div>
                        </div>
                        <h3>Add your child</h3>
                        <p class="lead mb-0">Add your child's name and avatar to our platform.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <div class="mx-auto">
                                <img src="/images/logo.png" alt="" style="width:100px;height:100px;">
                            </div>
                        </div>
                        <h3>Add their schedule</h3>
                        <p class="lead mb-0">Add their class schedule with links to their classrooms.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-paper-clip m-auto"></i>
                        </div>
                        <h3>Save the link</h3>
                        <p class="lead mb-0">Save the schedule link to your child's desktop / home screen.</p>
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
                    <h2>Easy To Use</h2>
                    <p class="lead mb-0">Easy to use schedule for primary, secondary or even high school children.</p>
                    <a target="_blank" href="/s/zulfa-juniadi">Example Schedule</a>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/attandance.jpg');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>Monitor Attendance</h2>
                    <p class="lead mb-0">Monitor attendance of your child's classes filterable by name and date.</p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/points.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Achievement Points</h2>
                    <p class="lead mb-0">Everytime your child attends their class, they'll be given a <i class="fa fa-star" style="color:gold"></i>. </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    {{-- <section class="testimonials text-center bg-light d-none">
        <div class="container">
            <h2 class="mb-5">What people are saying...</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-1.jpg" alt="">
                        <h5>Margaret E.</h5>
                        <p class="font-weight-light mb-0">"This is fantastic! Thanks so much guys!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-2.jpg" alt="">
                        <h5>Fred S.</h5>
                        <p class="font-weight-light mb-0">"Bootstrap is amazing. I've been using it to create lots of super nice landing pages."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-3.jpg" alt="">
                        <h5>Sarah W.</h5>
                        <p class="font-weight-light mb-0">"Thanks so much for making these free resources available to us!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">Ready to get started? Sign up now!</h2>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <div class="form-row">
                        <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3 mx-auto">
                            <a href="/app/register" class="btn btn-block btn-lg btn-primary">Sign up!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection