<table>
    <thead>
    <tr>
        <th><b>Title</b></th>
        <th><b>Paid for</b></th>
        <th><b>Paid By</b></th>
        <th><b>Who</b></th>
        <th><b>Name</b></th>
        <th><b>Type</b></th>
        <th><b>Date</b></th>
        <th><b>Amount</b></th>
        <th><b>Currency</b></th>
        <th><b>Rate</b></th>
        <th><b>AZN</b></th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->note }}</td>
            <td>{{ $transaction->paid_for }}</td>
            <td>{{ $transaction->paid_by }}</td>
            <td>{{ $transaction->who }}</td>
            <td>{{ $transaction->who == 'ADMIN' ? ($transaction->admin ? $transaction->admin->name : "-") : ($transaction->user ? $transaction->user->full_name : "-") }}</td>
            <td>{{ $transaction->type }}</td>
            <td>{{ $transaction->created_at }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->currency }}</td>
            <td>{{ $transaction->rate }}</td>
            <td>{{ $transaction->admin_amount }}</td>
        </tr>
    @endforeach

    {{--

        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>

        @foreach($types as $key => $amount)
            <tr>
                <td colspan="4">{{ $key }}</td>
                <td>{{ $amount }}</td>
            </tr>
        @endforeach
    --}}

    </tbody>
</table>