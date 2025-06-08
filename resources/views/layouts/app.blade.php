<!DOCTYPE html>
<html lang="en" data-menu-size="default" data-bs-theme="light">
     

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>Class Management Portal</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="A fully responsive premium admin dashboard template" />
     <meta name="author" content="Techzaa" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="csrf-token" content="{{ csrf_token() }}">


    @include('layouts.libraries.styles')
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <!-- ========== Topbar Start ========== -->
          @include('layouts.top-nav')

          <!-- Right Sidebar (Theme Settings) -->
          @include('layouts.right-sidebar')
          <!-- ========== Topbar End ========== -->

          <!-- ========== App Menu Start ========== -->
          @include('layouts.side-nav')
          <!-- ========== App Menu End ========== -->

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               <div class="container-fluid">

                    <!-- Start here.... -->

                    @yield('content')

               </div>
               <!-- End Container Fluid -->

               <!-- ========== Footer Start ========== -->
               @include('layouts.footer')
               <!-- ========== Footer End ========== -->

          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->

     </div>
     <!-- END Wrapper -->

     @include('layouts.libraries.scripts')
</body>

</html>