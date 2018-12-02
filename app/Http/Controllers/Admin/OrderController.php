<?php

namespace AvoRed\Framework\Order\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Order as Model;
use App\Models\OrderStatus;
use AvoRed\Framework\Mail\OrderInvoicedMail;
use AvoRed\Framework\Mail\UpdateOrderStatusMail;
use AvoRed\Framework\Order\DataGrid\OrderDataGrid;
use AvoRed\Framework\Order\Requests\UpdateOrderStatusRequest;
use AvoRed\Framework\Order\Requests\UpdateTrackCodeRequest;
use App\Contracts\Repository\OrderInterface;
use App\Contracts\Repository\OrderHistoryInterface;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
    *
    * @var \App\Repository\OrderRepository
    */
    protected $repository;

    public function __construct(OrderInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderGrid = new OrderDataGrid($this->repository->query()->orderBy('id', 'desc'));

        return view('avored-framework::order.index')->with('dataGrid', $orderGrid->dataGrid);
    }

    /**
     * View an Order Details
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Model $order)
    {
        $orderStatus = OrderStatus::all()->pluck('name', 'id');
        return view('avored-framework::order.view')->with('order', $order)->with('orderStatus', $orderStatus);
    }

    /**
     * Send an Order Invioced PDF to User
     * 
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmailInvoice(Model $order)
    {
        $user = $order->user;
        $view = view('avored-framework::mail.order-pdf')->with('order', $order);

        $folderPath = storage_path('app/public/uploads/order/invoice');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, '0775', true, true);
        }
        $path = $folderPath . DIRECTORY_SEPARATOR . $order->id . '.pdf';
        PDF::loadHTML($view->render())->save($path);

        Mail::to($user->email)->send(new OrderInvoicedMail($order, $path));

        return redirect()->back()->with('notificationText', 'Email Sent Successfully!!');
    }

    /**
     * Edit the Order Status View
     * 
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function editStatus(Model $order)
    {
        $orderStatus = OrderStatus::all()->pluck('name', 'id');
        
        $view = view('avored-framework::order.view')
            ->with('order', $order)
            ->with('orderStatus', $orderStatus)
            ->with('changeStatus', true);

        return $view;
    }

    /**
     * Change the Order Status
     * 
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Model $order, UpdateOrderStatusRequest $request)
    {
        //$order = Model::find($id);
        $order->update($request->all());

        $userEmail = $order->user->email;
        $orderStatusTitle = $order->orderStatus->name;

        $orderHistoryRepository = app(OrderHistoryInterface::class);
        $orderHistoryRepository->create(['order_id' => $order->id, 'order_status_id' => $request->get('order_status_id')]);

        Mail::to($userEmail)->send(new UpdateOrderStatusMail($orderStatusTitle));

        return redirect()->route('admin.order.index');
    }
    /**
     * Change the Order Status
     * 
     * @param \App\Models\Order $order
     * @param \AvoRed\Framework\Order\Request\UpdateTrackCodeRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTrackCode(Model $order, UpdateTrackCodeRequest $request)
    {
       
        $order->update(['track_code' => $request->track_code]);

        //Mail::to($userEmail)->send(new UpdateOrderStatusMail($orderStatusTitle));

        return redirect()->route('admin.order.index');
    }
}
