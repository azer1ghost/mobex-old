<table>
    <thead>
    <tr>
        <th><b>ID</b></th>
        <th><b>Name</b></th>
        <th><b>Surname</b></th>
        <th><b>Type</b></th>
        <th><b>Gender</b></th>
        <th><b>Limit</b></th>
        <th><b>Phone Number</b></th>
        <th><b>Email</b></th>
        <th><b>Filial</b></th>
        <th><b>Registered at</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->customer_id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->type }}</td>
            <td>{{ $user->gender ? 'Male' : 'Female' }}</td>
            <td>{{ $user->spending }}</td>
            <td>{{ App\Models\Extra\SMS::clearNumber($user->phone, true) }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->filial_name }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>