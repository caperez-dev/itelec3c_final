<?php
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Count total registered voters (not deleted)
    $registeredVoters = \App\Models\Voter::whereNull('deleted_at')->count();
    
    // Count voted users (has_voted = 1)
    $votedUsers = \App\Models\Voter::whereNull('deleted_at')
        ->where('has_voted', 1)
        ->count();
    
    // Calculate voter turnout percentage
    $voterTurnout = $registeredVoters > 0 
        ? round(($votedUsers / $registeredVoters) * 100, 2) 
        : 0;
    
    // You'll need to add these counts for candidates and positions later
    $totalCandidates = \App\Models\Candidate::whereNull('deleted_at')->count();
    $totalPositions = \App\Models\Position::whereNull('deleted_at')->count();
    
    return view('dashboard', compact(
        'registeredVoters',
        'votedUsers',
        'voterTurnout',
        'totalCandidates',
        'totalPositions'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Voter Routes
Route::get('/register-voter', [VoterController::class, 'create'])->name('register.voter');
Route::post('/register-voter', [VoterController::class, 'store'])->name('register.voter.store');
Route::get('/voter-registered/{id}', [VoterController::class, 'registrationSuccess'])->name('voter.registered.success');
Route::get('/voters', [VoterController::class, 'index'])->middleware('auth')->name('voters.list');
Route::get('/voters/{id}/edit', [VoterController::class, 'edit'])->name('voters.edit');
Route::put('/voters/{id}', [VoterController::class, 'update'])->name('voters.update');
Route::delete('/voters/{id}', [VoterController::class, 'destroy'])->name('voters.destroy');
Route::post('/voters/{id}/disable', [VoterController::class, 'disable'])->name('voters.disable');
Route::post('/voters/{id}/enable', [VoterController::class, 'enable'])->name('voters.enable');
Route::get('/display-archived-voters', [VoterController::class, 'ArchivedVotersDisplay'])->name('display.archived.voters');
Route::post('restore-voter/{id}', [VoterController::class, 'restore'])->name('restore.voter');
Route::delete('force-delete-voter/{id}', [VoterController::class, 'forceDelete'])->name('force.delete.voter');

// Candidate Routes
Route::get('/display-candidates', [CandidateController::class, 'index'])->name('display.candidates');
Route::get('/register-candidate', [CandidateController::class, 'create'])->name('register.candidate');
Route::post('/register-candidate', [CandidateController::class, 'store'])->name('register.candidate.store');
Route::get('/candidates/{id}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
Route::put('/candidates/{id}', [CandidateController::class, 'update'])->name('candidates.update');
Route::delete('/candidates/{id}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
Route::delete('force-delete-candidate/{id}', [CandidateController::class, 'forceDelete'])->name('force.delete.candidate');
Route::post('/candidates/{id}/disable', [CandidateController::class, 'disable'])->name('candidates.disable');
Route::post('/candidates/{id}/enable', [CandidateController::class, 'enable'])->name('candidates.enable');

// Vote Routes
Route::get('/display-votes', [VoteController::class, 'DisplayVotes'])->name('votes.display');
Route::get('/display-vote-counts', [VoteController::class, 'VoteCountsDisplay'])->name('display.vote.counts');

// Position Routes
// Active Positions
Route::get('/display-positions', [PositionController::class, 'PositionsDisplay'])->name('display.positions');

// Create Position form and store
Route::get('/create-position', [PositionController::class, 'create'])->name('position.create');
Route::post('/create-position', [PositionController::class, 'store'])->name('position.store');

// Trashed Positions
Route::get('/display-archived-positions', [PositionController::class, 'ArchivedPositionsDisplay'])->name('display.archived.positions');

// Soft Delete Position
Route::post('delete/{id}', [PositionController::class, 'delete'])->name('delete');

// Restore Position
Route::post('restore/{id}', [PositionController::class, 'restore'])->name('restore');

// Force Delete Position (Permanent)
Route::delete('force-delete-position/{id}', [PositionController::class, 'forceDelete'])->name('force.delete.position');

// Edit Position form and update
Route::get('/edit-position/{id}', [PositionController::class, 'edit'])->name('positions.edit');
Route::put('/positions/{id}', [PositionController::class, 'update'])->name('positions.update');

// Archived Candidates Routes
Route::get('/display-archived-candidates', [CandidateController::class, 'ArchivedCandidatesDisplay'])->name('display.archived.candidates');
Route::post('restore-candidate/{id}', [CandidateController::class, 'restore'])->name('restore.candidate');