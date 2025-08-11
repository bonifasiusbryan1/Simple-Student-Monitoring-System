<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="navbar-brand" href="/dashboard">
                <img src="/asset/img/logo.png" alt="logo undip">
                <small>Departemen Informatika</small>
            </a>
        </div>

        <div class="dropdown">
            <button class="btn-custom dropdown-toggle dropdown-toggle-end fs-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
                <label for="nama">
                    @if ($user->role == 'mahasiswa')
                        {{ substr($mahasiswa->nama, 0, 10) }}...
                    @elseif ($user->role == 'dosenwali')
                        {{ substr($dosenwali->nama, 0, 10) }}...
                    @elseif ($user->role == 'departemen')
                        {{ substr($departemen->nama, 0, 10) }}...
                    @elseif ($user->role == 'operator')
                        {{ substr($operator->nama, 0, 10) }}...
                    @endif
                </label>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="/profile/{{ auth()->user()->role }}"><i class="bi bi-person-circle"></i>Profile</a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/gantipassword"><i class="bi bi-lock"></i>Ganti Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-left"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>