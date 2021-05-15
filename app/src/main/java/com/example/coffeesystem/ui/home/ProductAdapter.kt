@file:Suppress("NAME_SHADOWING")

package com.example.coffeesystem.ui.home

import android.app.Activity
import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.DetailProductActivity
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Cart
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
import java.text.DecimalFormat
import java.util.*
import kotlin.collections.ArrayList

class ProductAdapter(private var mItems: ArrayList<Product>) :RecyclerView.Adapter<ProductAdapter.CustomViewHolder>()  {
    private var mItemsCopy  = ArrayList<Product>()

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ProductAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
                .inflate(R.layout.layout_product_item, parent, false)
        return CustomViewHolder(v)
    }

    override fun getItemCount(): Int {
        return mItems.size
    }
    override fun onBindViewHolder(holder: ProductAdapter.CustomViewHolder, position: Int) {
        val item: Product = mItems[position]
        holder.mTvName!!.text = item.name
        val dec = DecimalFormat("###,###.#")
        val price = dec.format(item.price)
        holder.mTvPrice!!.text= price
        holder.tvDescription!!.text=item.description
        Picasso.get().load(item.image).into(holder.mImage)
        holder.itemView.setOnClickListener(){
            val activity = holder.itemView.context as Activity
            val intent = Intent(activity, DetailProductActivity::class.java)
            intent.putExtra("Detail",item)
            activity.startActivity(intent)

        }
        }
    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var mTvName = itemView?.findViewById<TextView>(R.id.tv_name)
        var mTvPrice =itemView?.findViewById<TextView>(R.id.tv_price)
        var mImage  =itemView?.findViewById<ImageView>(R.id.img_product)
        var mImgBtnFavorite = itemView?.findViewById<ImageButton>(R.id.imgbtn_favorite)
        var mImgBtnCart = itemView?.findViewById<ImageButton>(R.id.imgbtn_cart)
        var tvDescription = itemView?.findViewById<TextView>(R.id.tv_description);
    }
    fun addItems(items: ArrayList<Product>) {
        mItems.clear()
        mItemsCopy.clear()
        mItems.addAll(items)
        mItemsCopy.addAll(items)

        notifyDataSetChanged()
    }
    interface ServiceCallback {
        fun onServiceClickCallBack(position: Int, id: String)
    }

    fun filterName(charText: String) {
        charText.toLowerCase(Locale.getDefault())
        mItems.clear()
        if (charText.isEmpty()){
            mItems.addAll(mItemsCopy)
        }else {
            mItems.clear()
            for (product: Product in mItemsCopy) {
                if (convertString(product.name!!.toLowerCase(Locale.getDefault())).contains(convertString(charText).toLowerCase(Locale.getDefault()))) {
                    mItems.add(product)
                }
            }
        }
        notifyDataSetChanged()
    }
    fun convertString(string: String): String{
        var searched=""
        for(i in string){
            var tmp = convert(i.toString())
            searched += tmp
        }
        return searched
    }
    private fun convert(str: String): String {
        var str = str
        str = str.replace("[àáạảãâầấậẩẫăằắặẳẵ]".toRegex(), "a")
        str = str.replace("[èéẹẻẽêềếệểễ]".toRegex(), "e")
        str = str.replace("[ìíịỉĩ]".toRegex(), "i")
        str = str.replace("[òóọỏõôồốộổỗơờớợởỡ]".toRegex(), "o")
        str = str.replace("[ùúụủũưừứựửữ]".toRegex(), "u")
        str = str.replace("[ỳýỵỷỹ]".toRegex(), "y")
        str = str.replace("đ".toRegex(), "d")
        str = str.replace("[ÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ]".toRegex(), "A")
        str = str.replace("[ÈÉẸẺẼÊỀẾỆỂỄ]".toRegex(), "E")
        str = str.replace("[ÌÍỊỈĨ]".toRegex(), "I")
        str = str.replace("[ÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ]".toRegex(), "O")
        str = str.replace("[ÙÚỤỦŨƯỪỨỰỬỮ]".toRegex(), "U")
        str = str.replace("[ỲÝỴỶỸ]".toRegex(), "Y")
        str = str.replace("Đ".toRegex(), "D")
        return str
    }
}


