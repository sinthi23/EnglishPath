<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        $enrollments = Enrollment::query()
            ->with(['user', 'course'])
            ->where('status', $status)
            ->latest()
            ->paginate(15);

        return view('admin.enrollments.index', compact('enrollments', 'status'));
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'approved',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Enrollment for student ' . $enrollment->user->email . ' approved successfully!');
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Enrollment for student ' . $enrollment->user->email . ' rejected successfully!');
    }
}
