<?php
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Auth\VoterAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

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
    
    // Count candidates and positions
    $totalCandidates = \App\Models\Candidate::whereNull('deleted_at')->count();
    $totalPositions = \App\Models\Position::whereNull('deleted_at')->count();
    
    // Get current election status (ID = 1)
    $election = \App\Models\Election::find(1);
    $electionStatus = $election ? $election->status : 'pending';
    
    return view('dashboard', compact(
        'registeredVoters',
        'votedUsers',
        'voterTurnout',
        'totalCandidates',
        'totalPositions',
        'electionStatus'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ===== VOTER LOGIN & VOTING ROUTES =====
Route::get('/voter-login', [VoterAuthController::class, 'showLoginForm'])->name('voter.login');
Route::post('/voter-authenticate', [VoterAuthController::class, 'authenticate'])->name('voter.authenticate');
Route::get('/voter/candidates', [VoteController::class, 'showCandidatesPage'])->name('voter.candidates');
Route::get('/voter/voting', [VoteController::class, 'showVotingPage'])->name('voter.voting');
Route::post('/voter/submit-vote', [VoteController::class, 'submitVote'])->name('voter.submit-vote');
Route::get('/voter/results', [VoteController::class, 'showResults'])->name('voter.results');
Route::post('/voter-logout', [VoterAuthController::class, 'logout'])->name('voter.logout');

// Voter Routes - Admin Only
Route::middleware('auth')->group(function () {
    Route::get('/register-voter', [VoterController::class, 'create'])->name('register.voter');
    Route::post('/register-voter', [VoterController::class, 'store'])->name('register.voter.store');
    Route::get('/voter-registered/{id}', [VoterController::class, 'registrationSuccess'])->name('voter.registered.success');
    Route::get('/voters', [VoterController::class, 'index'])->name('voters.list');
    Route::get('/voters/export-pdf', [VoterController::class, 'exportPDF'])->name('voters.export.pdf');
    Route::get('/voters/{id}/edit', [VoterController::class, 'edit'])->name('voters.edit');
    Route::put('/voters/{id}', [VoterController::class, 'update'])->name('voters.update');
    Route::delete('/voters/{id}', [VoterController::class, 'destroy'])->name('voters.destroy');
    Route::post('/voters/{id}/disable', [VoterController::class, 'disable'])->name('voters.disable');
    Route::post('/voters/{id}/enable', [VoterController::class, 'enable'])->name('voters.enable');
    Route::get('/display-archived-voters', [VoterController::class, 'ArchivedVotersDisplay'])->name('display.archived.voters');
    Route::post('restore-voter/{id}', [VoterController::class, 'restore'])->name('restore.voter');
    Route::delete('force-delete-voter/{id}', [VoterController::class, 'forceDelete'])->name('force.delete.voter');
});

// Election Control Routes
Route::middleware('auth')->group(function () {
    Route::post('/election/start', [App\Http\Controllers\ElectionController::class, 'start'])->name('election.start');
    Route::post('/election/pause', [App\Http\Controllers\ElectionController::class, 'pause'])->name('election.pause');
    Route::post('/election/resume', [App\Http\Controllers\ElectionController::class, 'resume'])->name('election.resume');
    Route::post('/election/end', [App\Http\Controllers\ElectionController::class, 'end'])->name('election.end');
});

// Candidate Routes - Admin Only
Route::middleware('auth')->group(function () {
    Route::get('/display-candidates', [CandidateController::class, 'index'])->name('display.candidates');
    Route::get('/candidates/export-pdf', [CandidateController::class, 'exportPDF'])->name('candidates.export.pdf');
    Route::get('/register-candidate', [CandidateController::class, 'create'])->name('register.candidate');
    Route::post('/register-candidate', [CandidateController::class, 'store'])->name('register.candidate.store');
    Route::get('/candidates/{id}/edit', [CandidateController::class, 'edit'])->name('candidates.edit');
    Route::put('/candidates/{id}', [CandidateController::class, 'update'])->name('candidates.update');
    Route::delete('/candidates/{id}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
    Route::delete('force-delete-candidate/{id}', [CandidateController::class, 'forceDelete'])->name('force.delete.candidate');
    Route::post('/candidates/{id}/disable', [CandidateController::class, 'disable'])->name('candidates.disable');
    Route::post('/candidates/{id}/enable', [CandidateController::class, 'enable'])->name('candidates.enable');
});

// Vote Routes
Route::get('/display-votes', [VoteController::class, 'DisplayVotes'])->name('votes.display');
Route::get('/votes/export-pdf', [VoteController::class, 'exportPDF'])->name('votes.export.pdf');
Route::get('/vote-counts/export-pdf', [VoteController::class, 'exportVoteCountsPDF'])->name('vote.counts.export.pdf');
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

// Settings Routes
Route::middleware('auth')->group(function () {
    // View settings page
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
    
    // Hard reset election system
    Route::post('/election/hard-reset', [App\Http\Controllers\ElectionController::class, 'hardReset'])->name('election.hard-reset');
});