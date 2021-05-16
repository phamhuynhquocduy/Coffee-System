package com.example.coffeesystem.cart

import android.app.Activity
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.DatabaseHandler
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Cart
import com.squareup.picasso.Picasso
import java.text.DecimalFormat


class CartAdapter(private var mItems: ArrayList<Cart>) : RecyclerView.Adapter<CartAdapter.CustomViewHolder>() {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CartAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
                .inflate(R.layout.activity_cart_item, parent, false)
        return CustomViewHolder(v)    }

    override fun onBindViewHolder(itemHolder: CartAdapter.CustomViewHolder, position: Int) {
        var cart: Cart = mItems[position]
        itemHolder.txtName?.text = cart.name
        val decimalFormat = DecimalFormat("###,###,###")
        itemHolder.txtPrice?.text = "Giá : " + decimalFormat.format(cart.price ).toString() + " đ"
        Picasso.get()
                .load(cart.image)
                .into(itemHolder.imageView)
        itemHolder.btnValues?.text = cart.count.toString() + ""
        val sl: Int = itemHolder.btnValues?.text.toString().toInt()
        when {
            sl >= 20 -> {
                itemHolder.btnPlus?.setBackgroundResource(R.drawable.custom_border_enable);
            }
            sl <= 1 -> {
                itemHolder.btnMinus?.setBackgroundResource(R.drawable.custom_border_enable);
            }
            else -> {
                itemHolder.btnPlus?.setBackgroundResource(R.drawable.custom_button);
                itemHolder.btnMinus?.setBackgroundResource(R.drawable.custom_button);
            }
        }
        itemHolder.imageButton?.setOnClickListener(){
            val activity = itemHolder.itemView.context as Activity
            val text = activity.findViewById<TextView>(R.id.txt_total)
            val textNotification = activity.findViewById<TextView>(R.id.textview_notification)
            val recyclerView = activity.findViewById<RecyclerView>(R.id.recyclerview_cart)
            val databaseHandler: DatabaseHandler = DatabaseHandler(activity)
            databaseHandler.deleteCart(cart)
            mItems.remove(cart)
            val decimalFormat = DecimalFormat("###,###,###")
            text.text = decimalFormat.format(CartActivity.eventTotal(activity)).toString() + " đ"
            notifyDataSetChanged()
            checkData(mItems,textNotification,recyclerView)
        }
        itemHolder.btnPlus?.setOnClickListener(){
            val activity = itemHolder.itemView.context as Activity
            val databaseHandler: DatabaseHandler = DatabaseHandler(activity)

            var count =  itemHolder.btnValues?.text.toString().toInt()
            if(count<20) {
                count += 1
                databaseHandler.updateCart(cart,count)
                setValueCount(count,itemHolder.btnMinus!!,itemHolder.btnPlus!!)
                val decimalFormat = DecimalFormat("###,###,###")
                val text = activity.findViewById<TextView>(R.id.txt_total)
                text.text = decimalFormat.format(CartActivity.eventTotal(activity)).toString() + " đ"
                itemHolder.btnValues?.text = count.toString()
            }
        }
        itemHolder.btnMinus?.setOnClickListener(){
            val activity = itemHolder.itemView.context as Activity
            val databaseHandler: DatabaseHandler = DatabaseHandler(activity)

            var count =  itemHolder.btnValues?.text.toString().toInt()
            if(count>0) {
                count -= 1
                databaseHandler.updateCart(cart,count)
                setValueCount(count,itemHolder.btnMinus!!,itemHolder.btnPlus!!)
                val decimalFormat = DecimalFormat("###,###,###")
                val text = activity.findViewById<TextView>(R.id.txt_total)
                text.text = decimalFormat.format(CartActivity.eventTotal(activity)).toString() + " đ"
                itemHolder.btnValues?.text = count.toString()
            }
        }
    }

    override fun getItemCount(): Int {
        return mItems.size
    }

    fun addItems(items: ArrayList<Cart>) {
        mItems.clear()
        mItems.addAll(items)

        notifyDataSetChanged()
    }

    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var txtName=itemView?.findViewById<TextView>(R.id.textview_name);
        var txtPrice=itemView?.findViewById<TextView>(R.id.textview_price);
        var imageView=itemView?.findViewById<ImageView>(R.id.imageview);
        var btnValues=itemView?.findViewById<Button>(R.id.button_values);
        var btnMinus=itemView?.findViewById<Button>(R.id.button_minus);
        var btnPlus=itemView?.findViewById<Button>(R.id.button_plus);
        var imageButton=itemView?.findViewById<ImageButton>(R.id.img_btn_cart);
    }
    private fun setValueCount( value: Int, buttonMinus: Button, buttonPlus: Button){
        when (value) {
            1 -> {
                buttonMinus.isEnabled = false
                buttonMinus.setBackgroundResource(R.drawable.custom_border_enable);
            }
            20 -> {
                buttonPlus.isEnabled=false
                buttonPlus.setBackgroundResource(R.drawable.custom_border_enable);

            }
            else -> {
                buttonMinus.isEnabled=true
                buttonPlus.isEnabled=true
                buttonPlus.setBackgroundResource(R.drawable.custom_button);
                buttonMinus.setBackgroundResource(R.drawable.custom_button);
            }
        }
    }
    private fun checkData(list : ArrayList<Cart>, textView: TextView, recyclerView: RecyclerView ) {
        if (list.size <= 0) {
            textView.visibility = View.VISIBLE
            recyclerView.visibility = View.INVISIBLE
        } else {
            textView.visibility = View.INVISIBLE
            recyclerView.visibility = View.VISIBLE
        }
    }
}