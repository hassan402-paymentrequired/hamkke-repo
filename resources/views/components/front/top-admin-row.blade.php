<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #662687;">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbtn">
                <a class="text-white nav-login-link" href="http://hamkke.test/admin">
                    <span class="ml-1" style="margin-right: 0.5em;">Logged-in as <span class="text-decoration-underline">{{ $authUser->getRoleData()->display_name }}</span>:: {{ $authUser->name }}</span>
                    <img src="{{ $authUser->avatar }}" alt="profile"
                         style="border-radius: 50%; max-height: 30px;">
                </a>
            </div>
        </div>

    </div>
</nav>
