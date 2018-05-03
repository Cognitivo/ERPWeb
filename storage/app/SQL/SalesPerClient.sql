select contacts.name as contact,
round(ifnull(sum(quantity * unit_price * vatco.coef),0),2) as sales
from sales_invoice as si
left join sales_invoice_detail as sd
on si.id_sales_invoice = sd.id_sales_invoice
left join(select app_vat_group.id_vat_group, sum(app_vat.coefficient) + 1 as coef
          from app_vat_group
          left join app_vat_group_details
          on app_vat_group.id_vat_group = app_vat_group_details.id_vat_group
          left join app_vat
          on app_vat_group_details.id_vat = app_vat.id_vat
          group by app_vat_group.id_vat_group) as vatco
on sd.id_vat_group = vatco.id_vat_group
left join contacts
on contacts.id_contact = si.id_contact
where si.trans_date between @StartDate and @EndDate
group by  si.id_contact;
