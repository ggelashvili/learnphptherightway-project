<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- TODO -->
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><!-- TODO --></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><!-- TODO --></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><!-- TODO --></td>
                </tr>
            </tfoot>
        </table>
        <form action="/transactions/upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
            <label for="transactions-file">Upload transactions:</label>
            <br>
            <input name="transactions-file[]" type="file" accept="text/csv" multiple>
            <br>
            <br>
            <input type="submit" value="Upload">
        </form>
    </body>
</html>
