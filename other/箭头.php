
/*
 * @Description: 
 * @Date: 2020-05-26 14:38:46
 * @LastEditTime: 2020-05-26 14:38:47
 */
FOREACH(Ptr<WfExpression>, argument, node->arguments) {
    int index = manager->expressionResolvings.Keys().IndexOf(argument.Obj());
    if (index != -1) {
        auto type = manager->expressionResolvings.Values()[index].type;
        if (! types.Contains(type.Obj())) {
            types.Add(type.Obj());
            if (auto group = type->GetTypeDescriptor()->GetMethodGroupByName(L"CastResult", true)) {
                int count = group->GetMethodCount();
                for (int i = 0; i < count; i++) { auto method = group->GetMethod(i);
                    if (method->IsStatic()) {
                        if (method->GetParameterCount() == 1 &&
                            method->GetParameter(0)->GetType()->GetTypeDescriptor() == description::GetTypeDescriptor<DescriptableObject>() &&
                            method->GetReturn()->GetTypeDescriptor() != description::GetTypeDescriptor<void>() ) {
                            symbol->typeInfo = CopyTypeInfo(method->GetReturn());
                            break;
                        }
                    }
                }
            }
        }
    }
}
[/cpp]

上面这段代码，可以把条件反过来写，然后就可以把箭头型的代码解掉了，重构的代码如下所示：

[cpp]
FOREACH(Ptr<WfExpression>, argument, node->arguments) {
    int index = manager->expressionResolvings.Keys().IndexOf(argument.Obj());
    if (index == -1)  continue;
    
    auto type = manager->expressionResolvings.Values()[index].type;
    if ( types.Contains(type.Obj()))  continue;
    
    types.Add(type.Obj());

    auto group = type->GetTypeDescriptor()->GetMethodGroupByName(L"CastResult", true);
    if  ( ! group ) continue;
 
    int count = group->GetMethodCount();
    for (int i = 0; i < count; i++) { auto method = group->GetMethod(i);
        if (! method->IsStatic()) continue;
       
        if ( method->GetParameterCount() == 1 &&
               method->GetParameter(0)->GetType()->GetTypeDescriptor() == description::GetTypeDescriptor<DescriptableObject>() &&
               method->GetReturn()->GetTypeDescriptor() != description::GetTypeDescriptor<void>() ) {
            symbol->typeInfo = CopyTypeInfo(method->GetReturn());
            break;
        }
    }
}
[/cpp]

这种代码的重构方式叫 <strong>Guard Clauses</strong>
<ul>
   <li><a href="https://martinfowler.com/" target="_blank">Martin Fowler</a> 的 Refactoring 的网站上有相应的说明《<a href="https://refactoring.com/catalog/replaceNestedConditionalWithGuardClauses.html" target="_blank">Replace Nested Conditional with Guard Clauses</a>》。</li>
</ul>
<ul>
   <li><a href="https://blog.codinghorror.com/" target="_blank">Coding Horror</a> 上也有一篇文章讲了这种重构的方式 —— 《<a href="https://blog.codinghorror.com/flattening-arrow-code/" target="_blank">Flattening Arrow Code</a>》</li>
</ul>
<ul>
   <li><a href="http://stackoverflow.com/" target="_blank">StackOverflow</a> 上也有相关的问题说了这种方式 —— 《<a href="http://stackoverflow.com/questions/356121/refactor-nested-if-statement-for-clarity" target="_blank">Refactor nested IF statement for clarity</a>》</li>
</ul>
这里的思路其实就是，<strong>让出错的代码先返回，前面把所有的错误判断全判断掉，然后就剩下的就是正常的代码了</strong>。
<h4>抽取成函数</h4>
微博上有些人说，continue 语句破坏了阅读代码的通畅，我觉得他们一定没有好好读这里面的代码，其实，我们可以看到，所有的 if 语句都是在判断是否出错的情况，所以，在维护代码的时候，你可以完全不理会这些 if 语句，因为都是出错处理的，而剩下的代码都是正常的功能代码，反而更容易阅读了。当然，一定有不是上面代码里的这种情况，那么，不用continue ，我们还能不能重构呢？

当然可以，抽成函数：

[cpp]bool CopyMethodTypeInfo(auto &method, auto &group, auto &symbol) 
{
    if (! method->IsStatic()) {
        return true;
    }
    if ( method->GetParameterCount() == 1 &&
           method->GetParameter(0)->GetType()->GetTypeDescriptor() == description::GetTypeDescriptor<DescriptableObject>() &&
           method->GetReturn()->GetTypeDescriptor() != description::GetTypeDescriptor<void>() ) {
        symbol->typeInfo = CopyTypeInfo(method->GetReturn());
        return false;
    }
    return true;
}

void ExpressionResolvings(auto &manager, auto &argument, auto &symbol) 
{
    int index = manager->expressionResolvings.Keys().IndexOf(argument.Obj());
    if (index == -1) return;
    
    auto type = manager->expressionResolvings.Values()[index].type;
    if ( types.Contains(type.Obj())) return;

    types.Add(type.Obj());
    auto group = type->GetTypeDescriptor()->GetMethodGroupByName(L"CastResult", true);
    if  ( ! group ) return;

    int count = group->GetMethodCount();
    for (int i = 0; i < count; i++) { auto method = group->GetMethod(i);
        if ( ! CopyMethodTypeInfo(method, group, symbol) ) break;
    }
}

...
...
FOREACH(Ptr<WfExpression>, argument, node->arguments) {
    ExpressionResolvings(manager, arguments, symbol)
}
...
...
[/cpp]

你发出现，抽成函数后，代码比之前变得更容易读和更容易维护了。不是吗？

有人说：“如果代码不共享，就不要抽取成函数！”，持有这个观点的人太死读书了。函数是代码的封装或是抽象，并不一定用来作代码共享使用，函数用于屏蔽细节，让其它代码耦合于接口而不是细节实现，这会让我们的代码更为简单，简单的东西都能让人易读也易维护。这才是函数的作用。
<h4>嵌套的 if 外的代码</h4>
微博上还有人问，原来的代码如果在各个 if 语句后还有要执行的代码，那么应该如何重构。比如下面这样的代码。

[c title="原版"]for(....) {
    do_before_cond1()
    if (cond1) {
        do_before_cond2();
        if (cond2) {
            do_before_cond3();
            if (cond3) {
                do_something();
            }
            do_after_cond3();
        }
        do_after_cond2();
    }
    do_after_cond1();
}

for(....) {
    do_before_cond1();
    if ( !cond1 ) {
        do_after_cond1();
        continue
    } 
    do_after_cond1();

    do_before_cond2();
    if ( !cond2 ) { 
        do_after_cond2();
        continue;
    }
    do_after_cond2();

    do_before_cond3();
    if ( !cond3 ) {
        do_after_cond3();
        continue;
    }
    do_after_cond3();

    do_something();  
}

for(....) {
    do_before_cond1();
    do_after_cond1();
    if ( !cond1 ) continue;
 
    do_before_cond2();
    do_after_cond2();
    if ( !cond2 ) continue;

    do_before_cond3();
    do_after_cond3();
    if ( !cond3 ) continue;

    do_something();  
}

for(....) {

    do_before_cond1();
    do_after_cond1();


    if ( !cond1 ) continue;  // <-- cond1 成了是否做第二个语句块的条件
    do_before_cond2();
    do_after_cond2();

    if ( !cond2 ) continue; // <-- cond2 成了是否做第三个语句块的条件
    do_before_cond3();
    do_after_cond3();

    if ( !cond3 ) continue; //<-- cond3 成了是否做第四个语句块的条件
    do_something(); 
 
}

bool do_func3() {
   do_before_cond2();
   do_after_cond2();
   return cond3;
}

bool do_func2() {
   do_before_cond2();
   do_after_cond2();
   return cond2;
}

bool do_func1() {
   do_before_cond1();
   do_after_cond1();
   return cond1;
}

// for-loop 你可以重构成这样
for (...) {
    bool cond = do_func1();
    if (cond) cond = do_func2();
    if (cond) cond = do_func3();
    if (cond) do_something();
}

// for-loop 也可以重构成这样
for (...) {
    if ( ! do_func1() ) continue;
    if ( ! do_func2() ) continue;
    if ( ! do_func3() ) continue;
    do_something();
}

int ConnectPeer2Peer(Conn *pA, Conn* pB, Manager *manager)
{
    if ( pA->isConnected() ) {
        manager->Prepare(pA);
        if ( pB->isConnected() ) {
            manager->Prepare(pB);
            if ( manager->ConnectTogther(pA, pB) ) {
                pA->Write("connected");
                pB->Write("connected");
                return S_OK;
            }else{
                return S_ERROR;
            }

        }else {
            pA->Write("Peer is not Ready, waiting...");
            return S_RETRY;
        }
    }else{
        if ( pB->isConnected() ) {
            manager->Prepare();
            pB->Write("Peer is not Ready, waiting...");
            return S_RETRY;
        }else{
            pA->Close();
            pB->Close();
            return S_ERROR;
        }
    }
    //Shouldn't be here!
    return S_ERROR;
}


