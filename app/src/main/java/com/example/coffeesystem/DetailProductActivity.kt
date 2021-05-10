package com.example.coffeesystem

import android.annotation.SuppressLint
import android.os.Bundle
import android.view.View
import androidx.appcompat.app.AppCompatActivity
import com.example.coffeesystem.databinding.ActivityDetailProductBinding
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
import java.text.DecimalFormat

class DetailProductActivity : AppCompatActivity() {
    private lateinit var binding: ActivityDetailProductBinding

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityDetailProductBinding.inflate(layoutInflater)
        val view = binding.root
        setContentView(view)

        var count =  binding.buttonValues.text.toString().toInt()
        setValueCount(count)

        val product = intent.getSerializableExtra("Detail") as? Product
        binding.textviewName.text = product?.name
        binding.textviewDescription.text = product?.description
        val dec = DecimalFormat("###,###.#")
        val price = dec.format(product?.price)
        binding.textviewPrice.text = price
        Picasso.get().load(product?.image)
                .into(binding.imageview)

        binding.buttonMinus.setOnClickListener(){
            var count =  binding.buttonValues.text.toString().toInt()
            if(count>1) {
                count -= 1
                setValueCount(count)
                binding.buttonValues.text = count.toString()
            }
        }
        binding.buttonPlus.setOnClickListener(){
            var count =  binding.buttonValues.text.toString().toInt()
            if(count<20) {
                count += 1
                setValueCount(count)
                binding.buttonValues.text = count.toString()
            }
        }
    }
    private fun setValueCount( value: Int){
        when (value) {
            1 -> {
                binding.buttonMinus.isEnabled = false
                binding.buttonMinus.setBackgroundResource(R.drawable.custom_border_enable);
            }
            20 -> {
                binding.buttonPlus.isEnabled=false
                binding.buttonPlus.setBackgroundResource(R.drawable.custom_border_enable);

            }
            else -> {
                binding.buttonMinus.isEnabled=true
                binding.buttonPlus.isEnabled=true
                binding.buttonPlus.setBackgroundResource(R.drawable.custom_border_radius);
                binding.buttonMinus.setBackgroundResource(R.drawable.custom_border_radius);
            }
        }
    }
}
