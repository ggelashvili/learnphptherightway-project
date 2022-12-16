<?php

  if (isset($_SESSION['success_msg']) && $_SESSION['success_msg']) {
      echo $_SESSION['success_msg'];
      unset($_SESSION['success_msg']);
  }

  if (isset($_SESSION['error_msg']) && $_SESSION['error_msg']) {
      echo $_SESSION['error_msg'];
      unset($_SESSION['error_msg']);
  }
