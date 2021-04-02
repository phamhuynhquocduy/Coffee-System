package com.example.coffeesystem.ui.home

import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
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
        holder.mTvPrice!!.text= item.price.toString()
        Picasso.get().load(item.image).into(holder.mImage)
        }
    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var mTvName = itemView?.findViewById<TextView>(R.id.tv_name)
        var mTvPrice =itemView?.findViewById<TextView>(R.id.tv_price)
        var mImage  =itemView?.findViewById<ImageView>(R.id.img_product)
        var mImgBtnFavorite = itemView?.findViewById<ImageButton>(R.id.imgbtn_favorite)
        var mImgBtnCart = itemView?.findViewById<ImageButton>(R.id.imgbtn_cart)
    }
    fun addItems(items: ArrayList<Product>) {
        mItems.clear()
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
            for (product: Product in mItemsCopy) {
                if (product.name.toLowerCase(Locale.getDefault()).contains(charText)) {
                    mItems.add(product)
                }
            }
        }
        notifyDataSetChanged()
    }
}