<?php
    include 'send_money.php';
?>
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
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="send.php">Re-Send Money</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <main role="main" class="pb-3">
        <h3>Send Money Request</h3>
        <dl>
            <dt>Message To Recipients</dt>
            <dd><?= $request->getMsgToRecipients(); ?></dd>
        </dl>
        <h5>Recipients</h5>
        <table class="table col-md-8">
            <thead>
                <tr>
                    <th>Email/Phone</th>
                    <th>Customer Code</th>
                    <th class="text-right">Amount (ETB)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($request->getRecipients() as $recipient): ?>
                <tr>
                    <td><?= $recipient->getEmail(); ?></td>
                    <td><?= $recipient->getCustomerCode(); ?></td>
                    <td class="text-right"><?= number_format($recipient->getAmount(), 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right" colspan="2">Total</th>
                    <th class="text-right"><?= number_format($request->getTotalPayment(), 2); ?></th>
                </tr>
            </tfoot>
        </table>

        <dl>
            <dt>Payer Signature</dt>
            <dd><p><?= $request->getPayerSignature(); ?></p></dd>
        </dl>
        <h5>Request JSON</h5>
        <div class="row">
            <pre class="col-md-10">
            <?= json_encode($request, JSON_PRETTY_PRINT); ?>
            </pre>
        </div>
        <hr class="text-muted my-2" />

        <h3>Send Money Response</h3>
        <h5 class="text-muted">Http Status : <?= $response->getHttpStatusCode(); ?></h5>
        <?php if ($response->getIsError()): ?>
            <h4 class="text-danger">Error</h4>
            <p class="text-danger"><?= $response->getErrorMessage(); ?></p>
        <?php endif ?>
        <?php if(!is_null($response->getSuccessResult())): ?>
        <h5>Summary</h5>
            <dl class="row">
                <dt class="col-md-2">Status</dt>
                <dd class="col-md-10"><?= $response->getSuccessResult()->getStatusText(); ?></dd>
                <dt class="col-md-2">Status Description</dt>
                <dd class="col-md-10"><?= $response->getSuccessResult()->getStatusDescription(); ?></dd>
                <?php if($response->getShouldContinueManually()): ?>
                    <dt class="col-md-2">Continue Manually</dt>
                    <dd class="col-md-10">Yes</dd>
                    <dt class="col-md-2">Continue Url</dt>
                    <dd class="col-md-10"><a href="<?= $response->getManualContinueUrl(); ?>"><?= $response->getManualContinueUrl(); ?></a></dd>
                <?php endif ?>
            </dl>
        <?php endif ?>
        <h5>Response JSON</h5>
        <div class="row">
            <pre class="col-md-10">
            <?= json_encode($response, JSON_PRETTY_PRINT); ?>
            </pre>
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