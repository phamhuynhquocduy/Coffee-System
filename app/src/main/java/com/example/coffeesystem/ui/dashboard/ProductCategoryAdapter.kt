package com.example.coffeesystem.ui.dashboard

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
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
import java.text.DecimalFormat

class ProductCategoryAdapter (private var mItems: ArrayList<Product>) : RecyclerView.Adapter<ProductCategoryAdapter.CustomViewHolder>()  {
    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): ProductCategoryAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
            .inflate(R.layout.layout_product_item, parent, false)
        return CustomViewHolder(v)
    }

    override fun onBindViewHolder(holder: ProductCategoryAdapter.CustomViewHolder, position: Int) {
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

    override fun getItemCount(): Int {
        return mItems.size
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
        mItems.addAll(items)

        notifyDataSetChanged()
    }

}