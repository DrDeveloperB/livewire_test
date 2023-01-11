<?php

namespace App\Http\Livewire;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Emoji\Emoji;

class TicketAdd extends Component
{
    use WithFileUploads;

    public $newTicket = '';
    public $image;
    public $customError;

    protected $listeners = [
        'ticketFileUpload' => 'handleFileUpload',
    ];

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
//    protected $stopOnFirstFailure = true;

    /**
     * 입력 값 검증
     * $this->validate() 에서 사용
     * @var string[]
     */
    protected $rules = [
        'newTicket' => 'required|min:10|max:100',
    ];

    public $swalMsg = [
        'add' => array(
            'title' => '저장 완료',
            'text' => '질문이 작성되었습니다.',
        ),
    ];

    protected $messages = [
        'newTicket.required' => '입력된 내용이 없습니다.',
        'newTicket.min' => '최소 10자이상 입력해주세요.',
        'newTicket.max' => '최데 100자이하로 입력해주세요.',
    ];

    public function render()
    {
        return view('livewire.ticket-add');
    }

    public function addTicket(Request $request)
    {
        $this->newTicket = trim($this->newTicket);

        // use $rules
        $this->validate();

        $image = $this->storeImage();

//        DB::enableQueryLog();
        SupportTicket::create(
            [
                'user_id' => Auth::user()->id,
                'question' => $this->newTicket,
                'image' => $image,
            ]
        );
//        dd(getSqlWithBindings(DB::getQueryLog()));

        $this->newTicket = '';
        $this->image = '';

        $msg = sprintf('%s %s',
            $this->swalMsg['add']['text'],
            Emoji::CHARACTER_GRINNING_FACE_WITH_SMILING_EYES
        );

        $this->emit('swalSuccess',
            ['title' => $this->swalMsg['add']['title'], 'text' => $msg]
        );

        $this->emit('refreshTickets');
    }

    public function handleFileUpload(Request $request, $imageData)
    {
        $this->image = $imageData;
    }

    public function storeImage()
    {
        if (!$this->image) return null;

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = date('Ymd_His_') . Str::random() . '.jpg';
        Storage::disk('ticket')->put($name, $img);
        return $name;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [$field => 'min:10|max:100']);
    }
}
