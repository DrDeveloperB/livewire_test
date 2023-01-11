<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Http\Request;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Emoji\Emoji;

class CommentAdd extends Component
{
    use WithFileUploads;

    public $newComment = '';
    public $image;
    public $ticketId;
    public $customError;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected'
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
        'newComment' => 'required|min:10',
    ];

    public $swalMsg = [
        'add' => array(
            'title' => '저장 완료',
            'text' => '댓글이 작성되었습니다.',
        ),
        'remove' => array(
            'title' => '삭제 완료',
            'text' => '#{commentId}번 댓글이 삭제되었습니다.',
        ),
        'confirm' => array(
            'title' => '삭제 확인',
            'text' => '#{commentId}번 댓글을 삭제하시겠습니까?',
        ),
    ];

    protected $messages = [
        'ticketId.required' => '질문이 선택되지 않았습니다.',
        'newComment.required' => '입력된 내용이 없습니다.',
        'newComment.min' => '최소 10자이상 입력해주세요.',
        'newComment.max' => '최데 100자이하로 입력해주세요.',
    ];

    public function render()
    {
        return view('livewire.comment-add');
    }

    public function addComment(Request $request)
    {
        // use $rules
//        $this->validate();

        $this->newComment = trim($this->newComment);
//        dd($this->newComment);
//        dd($request->query('newComment'));

        // 어떻게 사용하는거지?
//        $this->addError('newComment', '입력된 내용이 없습니다.');
//        $validator = Validator::make($request->all(), [
//            'ticketId' => 'bail|required',
//            'newComment' => 'required|min:10|max:100',
//        ]);
//        if ($validator->stopOnFirstFailure()->fails()) {
//            dd($validator->errors());
//        }
//        // ->stopOnFirstFailure(true)
//        $validator->sometimes('ticketId', 'bail|required', function ($input) {
////            dd(empty($this->ticketId));
//            return false;
////            $input->serverMemo('ticketId') = $this->ticketId;
////            dd($input->serverMemo());
////            return !empty($this->ticketId);
//        });
////        dd($validator->errors()->first('ticketId'));
////        $this->customError = $validator->errors();
////        dd($this->customError->first('ticketId'));

//        $validator = $this->validate(['ticketId' => 'bail|required']);
//        dd($validator);
        $this->validate(
            [
                'ticketId' => 'bail|required',
                'newComment' => 'required|min:10|max:100',
            ]
        );
//        if (empty($this->newComment)) return;
        $image = $this->storeImage();

        $createdComment = Comment::create(
            [
                'user_id' => 1,
                'body' => $this->newComment,
                'image' => $image,
                'support_ticket_id' => $this->ticketId,
            ]
        );

        // 기존 글 목록에 신규 글 추가
        // public $comments 제거시 같이 제거
//        $this->comments->prepend($createdComment);
//        $this->comments->push($createdComment);
        $this->newComment = '';
        $this->image = '';

        $msg = sprintf('%s %s',
            $this->swalMsg['add']['text'],
            Emoji::CHARACTER_GRINNING_FACE_WITH_SMILING_EYES
        );
//        $msg = 'Comment added successfully! ' . Emoji::CHARACTER_GRINNING_FACE_WITH_SMILING_EYES;

        $this->emit('swalSuccess',
            ['title' => $this->swalMsg['add']['title'], 'text' => $msg]
        );

//        session()->flash('message',
//            $msg
//        );
//        $this->emit('alert_remove');

        // 부모 템플릿 새로고침
        $this->emit('refreshComments');
    }

    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
        $this->validate(
            [
                'ticketId' => 'bail|required',
            ]
        );
//        Validator::get
//        $this->errors = new MessageBag;
    }

    public function handleFileUpload(Request $request, $imageData)
    {
//        $requestAll = $request->all();
//        dump($requestAll['updates'][0]['payload']['params'][0]);
//        $this->image = $requestAll['updates'][0]['payload']['params'][0];
        $this->image = $imageData;
    }

    public function storeImage()
    {
        if (!$this->image) return null;

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = date('Ymd_His_') . Str::random() . '.jpg';
        Storage::disk('custom_01')->put($name, $img);
        return $name;
    }

    public function updated($field)
    {
//        sleep(3);
//        if (in_array($field, ['newComment'])) {
            $this->validateOnly($field, [$field => 'min:10|max:100']);
//        }
    }
}
