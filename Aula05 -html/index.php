<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bank Account Management</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="container">
    <h1>Bank Account Management</h1>
    <form method="post">
      <label for="owner">Account Owner:</label>
      <input type="text" id="owner" name="owner" required>

      <label for="accountType">Account Type:</label>
      <select id="accountType" name="accountType" required>
        <option value="CC">Checking Account (CC)</option>
        <option value="CP">Savings Account (CP)</option>
      </select>

      <button type="submit" name="action" value="create">Create Account</button>
    </form>

    <?php
      require_once 'ContaBanco.php';

      session_start();

      if (!isset($_SESSION['accounts'])) {
        $_SESSION['accounts'] = [];
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $owner = $_POST['owner'];
        $accountType = $_POST['accountType'];
        
        if ($_POST['action'] === 'create') {
          $account = new ContaBanco();
          $account->abrirConta($accountType);
          $account->setDono($owner);
          $account->setNumConta(count($_SESSION['accounts']) + 1); // Simple account number generation
          $_SESSION['accounts'][] = $account;
          echo "<p>Account created successfully for {$owner}!</p>";
        }
      }

      foreach ($_SESSION['accounts'] as $account) {
        echo "<div class='account-details'>";
        echo "<h2>Account Details</h2>";
        echo "<p>Owner: " . $account->getDono() . "</p>";
        echo "<p>Account Number: " . $account->getNumConta() . "</p>";
        echo "<p>Account Type: " . $account->getTipo() . "</p>";
        echo "<p>Balance: R$ " . number_format($account->getSaldo(), 2, ',', '.') . "</p>";
        echo "</div>";
      }
    ?>
  </div>
</body>
</html>