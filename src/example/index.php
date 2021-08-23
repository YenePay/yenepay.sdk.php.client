<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YenePay SendMoney Client Example</title>
    <link rel="stylesheet" href="web/lib/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="web/css/site.css" />
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" href="index.php">YenePay SendMoney Client Example</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse align-items-end collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a class="nav-link text-dark" href="index.php">Home</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="send.php">Send Money</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <main role="main" class="pb-3">
        <div class="text-center">
    <h1 class="display-4">Welcome to YenePay Send Money Client Example</h1>
    <div class="my-5">
        <a class="btn btn-primary btn-lg" href="send.php">Send Money</a>
    </div>
    <p>Learn about <a href="https://yenepay.com/developer">building payment with YenePay</a>.</p>
</div>
        </main>
    </div>

    <footer class="border-top footer text-muted">
        <div class="container">
            &copy; 2021 - YenePay Client PHP SDK Example
        </div>
    </footer>
    <script src="web/lib/jquery/dist/jquery.min.js"></script>
    <script src="web/lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
