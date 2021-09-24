<?php

namespace App\Http\Livewire;

use App\Http\Resources\CommentCollection;
use App\Models\Comment;
//use http\Env\Request;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Spatie\Emoji\Emoji;
use Symfony\Component\Console\Input\Input;

class Comments extends Component
{
    use WithPagination;
    use WithFileUploads;

    /**
     * 페이징 테마 선택
     * tailwind, simple-tailwind, bootstrap, simple-bootstrap
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * view 호출 메소드에서 데이터를 전달하고
     * 동일한 속성명(변수명)이 선언되어 있으면 view 는 선언되어있는 속성을 참조하므로 결과가 달라짐
     * 타입이 다른경우 오류발생
     */
//    public $comments;
//    public array $comments = [
//        [
//            'id' => 1,
//            'creator' => 'name',
//            'created_at' => 'time',
//            'body' => 'contents',
//        ]
//    ];
//    public SupportTicket $tickets;
    public $newComment = '';
    public $image;
    public $ticketId;

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
        'ticketSelected',
        'refreshComments' => '$refresh',
    ];

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
        'newComment.required' => '입력된 내용이 없습니다.',
        'newComment.min' => '최소 10자이상 입혁해주세요.',
        'newComment.max' => '최데 100자이하로 입혁해주세요.',
    ];

//    public function mount($initialComments)
//    {
////        $this->comments = $initialComments;
////        $this->comments = Comment::all();
//
////        $this->comments = Comment::select('id', 'user_id', 'body', 'created_at')
//////            ->orderByDesc('id')
////            ->latest()      // order by primary key desc
////            ->get();
//////            ->paginate(2);      // view 호출 메소드에서 사용 가능
//
//        // 오류 발생
////        $this->comments = CommentCollection::collection($this->comments);
//    }

    public function render()
    {
//        sleep(5);
//        alert()->success('Success Title', 'Success Message - alert helper');
//        Alert::success('Success Title', 'Success Message - use Class');

        $comments = array();
        if ($this->ticketId) {
            $comments = Comment::select('id', 'user_id', 'body', 'created_at', 'image')
                ->where('support_ticket_id', $this->ticketId)
//            ->orderByDesc('id')
                ->latest()      // order by primary key desc
//            ->get();
                ->paginate(3)      // view 호출 메소드에서만 사용 가능
//            ->paginate(3, ['*'], 'commentsPage')
                // $post->comments()->paginate(10, ['*'], 'commentsPage')
            ;
        }

        $data['comments'] = $comments;      // new \stdClass();

        return view('livewire.comments', $data);
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

        $this->validate(['newComment' => 'required|min:10|max:100']);
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

        $this->resetPage();
    }

    public function storeImage()
    {
        if (!$this->image) return null;

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = date('Ymd_His_') . Str::random() . '.jpg';
        Storage::disk('custom_01')->put($name, $img);
        return $name;
    }

    public function remove($commentId)
    {
        $comment = Comment::find($commentId);
        $comment->delete();
        Storage::disk('custom_01')->delete($comment->image);

        // public $comments 제거시 같이 제거
//        $this->comments = $this->comments->except($commentId);
//        $this->comments = $this->comments->where('id', '!=', $commentId);

        $msg = sprintf('%s %s',
            Str::replace('#{commentId}', $commentId, $this->swalMsg['remove']['text']),
            Emoji::CHARACTER_WEARY_FACE
        );
//        $msg = 'Comment deleted successfully! ' . Emoji::CHARACTER_WEARY_FACE;

        $this->emit('swalSuccess',
            [
                'title' => $this->swalMsg['remove']['title'],
                'text' => $msg
            ]
        );
    }

    public function handleFileUpload(Request $request, $imageData)
    {
//        $requestAll = $request->all();
//        dump($requestAll['updates'][0]['payload']['params'][0]);
//        $this->image = $requestAll['updates'][0]['payload']['params'][0];
        $this->image = $imageData;
    }

    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }

//    public function swalConfirm($commentId, $title, $text)
//    {
////        dd($commentId . $title . $text);
////        $result = $this->emit('swalConfirm',
////            ['commentId' => $commentId, 'title' => $title, 'text' => $text]
//////            ['title' => $this->swalMsg['remove']['title'], 'text' => $this->swalMsg['remove']['text']]
////        );
////        dump($result);
//    }
//
//    public function swalConfirm2($commentId)
//    {
//        dd($commentId);
//    }
//
//    public function swalConfirm3($commentId)
//    {
//        $this->emit('swalSuccess',
//            ['title' => $this->swalMsg['remove']['title'], 'text' => $this->swalMsg['remove']['text']]
//        );
//    }

//    public function updated($field)
//    {
////        sleep(3);
//        $this->validateOnly($field, [$field => 'min:10|max:100']);
//    }
}
