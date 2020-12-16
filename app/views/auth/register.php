<header>
    <div class="container">
        <h1 class="text-center my-5">Create an account</h1>
    </div>
</header>
<section>
    <div class="container">
        <div class="d-flex justify-content-between my-3">
            <h5>Please register bellow</h5>
            <a class="btn btn-primary" href="/auth/login">Login</a>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="text" name="password" class="form-control" id="password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="text" name="confirmPassword" class="form-control" id="confirmPassword">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</section>