@extends('admin_template')

@section('body')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <a href="{{ url('admin/book/create') }}" class="btn btn-primary">Create</a>
        </div>
        <div class="col">
            <a href="{{ route('admin.book.export') }}" class="btn btn-info">Export</a>
        </div>
    </div>
    <table class="table">
        <tr>
            <td>ID</td>
            <td>Category</td>
            <td>Name</td>
            <td>IBAN</td>
            <td>Language</td>
            <td>Actions</td>
        </tr>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>
                    @if($book->category)
                        {{ $book->category->name }}
                    @endif
                </td>
                <td><a href="{{ url('admin/book/show', $book->id) }}">{{ $book->name }}</a></td>
                <td>{{ $book->iban }}</td>
                <td>{{ $book->language }}</td>
                <td>
                    <a href="{{ route('admin.book.edit', $book->id) }}">Edit</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

